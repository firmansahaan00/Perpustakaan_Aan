<?php

namespace App\Http\Controllers\KepalaPerpus;

use App\Models\Anggota;
use App\Models\kepala_perpus;
use App\Models\Petugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    // MENAMPILKAN SEMUA AKUN
    public function index()
    {
        $users = User::latest()->get();
        return view('kepala.akun.index', compact('users'));
    }

    // FORM TAMBAH AKUN
    public function create()
    {
        return view('kepala.akun.create');
    }

    // SIMPAN DATA
    public function store(Request $request)
    {
        $rules = [
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role'    => 'required|in:anggota,petugas,kepala',
        ];

        if ($request->role == 'anggota') {
            $rules['nis']   = 'required|unique:anggota,nis';
            $rules['kelas'] = 'required';
        } elseif ($request->role == 'petugas') {
            $rules['nip_petugas'] = 'nullable|unique:petugas,nip_petugas';
        } elseif ($request->role == 'kepala') {
            $rules['nip_kepala'] = 'nullable|unique:kepala_perpus,nip_kepala';
        }

        $request->validate($rules);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'    => $request->role,
            ]);

            if ($request->role == 'anggota') {
                Anggota::create([
                    'user_id' => $user->id,
                    'nis'     => $request->nis,
                    'kelas'   => $request->kelas,
                    'alamat'  => $request->alamat,
                ]);
            } elseif ($request->role == 'petugas') {
                Petugas::create([
                    'user_id'     => $user->id,
                    'nip_petugas' => $request->nip_petugas,
                    'no_hp'       => $request->no_hp,
                ]);
            } elseif ($request->role == 'kepala') {
                kepala_perpus::create([
                    'user_id'    => $user->id,
                    'nip_kepala' => $request->nip_kepala,
                ]);
            }

            DB::commit();
            return redirect()->route('kepala.akun.index')
                ->with('success', 'Akun berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // FORM EDIT
    public function edit($id)
    {
        $user = User::with(['anggota','petugas','kepala'])->findOrFail($id);
        return view('kepala.akun.edit', compact('user'));
    }

    // UPDATE DATA (FIX TOTAL)
    public function update(Request $request, $id)
    {
        $user = User::with(['anggota','petugas','kepala'])->findOrFail($id);

        $rules = [
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ];

        // VALIDASI DINAMIS (AMAN DARI NULL)
        if ($user->role == 'anggota' && $user->anggota) {
            $rules['nis']   = 'required|unique:anggota,nis,' . $user->anggota->id;
            $rules['kelas'] = 'required';
        } elseif ($user->role == 'petugas' && $user->petugas) {
            $rules['nip_petugas'] = 'nullable|unique:petugas,nip_petugas,' . $user->petugas->id;
        } elseif ($user->role == 'kepala' && $user->kepala) {
            $rules['nip_kepala'] = 'nullable|unique:kepala_perpus,nip_kepala,' . $user->kepala->id;
        }

        $request->validate($rules);

        DB::beginTransaction();
        try {
            // UPDATE USER
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            // UPDATE RELASI (AMAN)
            if ($user->role == 'anggota' && $user->anggota) {
                $user->anggota->update([
                    'nis'    => $request->nis,
                    'kelas'  => $request->kelas,
                    'alamat' => $request->alamat,
                ]);
            } elseif ($user->role == 'petugas' && $user->petugas) {
                $user->petugas->update([
                    'nip_petugas' => $request->nip_petugas,
                    'no_hp'       => $request->no_hp,
                ]);
            } elseif ($user->role == 'kepala' && $user->kepala) {
                $user->kepala->update([
                    'nip_kepala' => $request->nip_kepala,
                ]);
            }

            DB::commit();

            return redirect()->route('kepala.akun.index')
                ->with('success', 'Akun berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    // DETAIL
    public function detail($id)
    {
        $user = User::with(['anggota','petugas','kepala'])->findOrFail($id);
        return view('kepala.akun.view', compact('user'));
    }

    // HAPUS
    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('kepala.akun.index')
            ->with('success', 'Akun berhasil dihapus!');
    }
}
