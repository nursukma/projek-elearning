<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Str;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Siswa::with('fkSiswaKelas')->get();
        $kelas = Kelas::all();
        return view('siswa.index', compact('data', 'kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nis' => 'required|max:18',
            'nama_siswa' => 'required|string|max:50',
            'tlp_siswa' => 'required|max:12',
            'alamat_siswa' => 'required|string|max:255',
        ]);

        $username = explode(" ", $data['nama_siswa']);
        $dataUser = User::where('username', $username[0])->get()->count();

        if ($dataUser > 0) {
            $randomString = Str::lower(Str::random(3));
            $randomNumber = Str::random(2, '1234567890');
            $random = $randomString . $randomNumber;

            $user = User::create([
                'name' => $data['nama_siswa'],
                'username' => $username[0] . $random,
                'password' => bcrypt($username[0]),
                'role' => 'Siswa',
                'stts' => 1
            ]);
        } else {
            $user = User::create([
                'name' => $data['nama_siswa'],
                'username' => $username[0],
                'password' => bcrypt($username[0]),
                'role' => 'Siswa',
                'stts' => 1
            ]);
        }

        $dataStore = Siswa::create([
            'nis' => $data['nis'],
            'nama_siswa' => $data['nama_siswa'],
            'tlp_siswa' => $data['tlp_siswa'],
            'alamat_siswa' => $data['alamat_siswa'],
            'jk_siswa' => $request->jk_siswa,
            'id_kelas' => $request->id_kelas,
            'id_user' => $user->id
        ]);

        if (!$user) {
            return back()->with('error', 'Gagal tambah data');
        } else {
            if (!$dataStore) {
                return back()->with('error', 'Gagal tambah data');
            }
        }
        return back()->with('message', 'Berhasil tambah data');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'edit_nis' => 'required|max:18',
            'edit_nama_siswa' => 'required|string|max:50',
            'edit_tlp_siswa' => 'required|max:12',
            'edit_alamat_siswa' => 'required|string|max:255',
        ]);

        $user = User::find($siswa->id_user);

        $username = explode(" ", $validated['edit_nama_siswa']);

        $dataUser = User::where('username', $username[0])->get()->count();

        if ($dataUser > 0) {
            $randomString = Str::lower(Str::random(3));
            $randomNumber = Str::random(2, '1234567890');
            $random = $randomString . $randomNumber;

            $user->username = $username[0] . $random;
            $user->name = $validated['edit_nama_siswa'];
            $userUpdate = $user->save();
        } else {
            $user->username = $username[0];
            $user->name = $validated['edit_nama_siswa'];
            $userUpdate = $user->save();
        }

        $data = [
            'nis' => $validated['edit_nis'],
            'nama_siswa' => $validated['edit_nama_siswa'],
            'tlp_siswa' => $validated['edit_tlp_siswa'],
            'alamat_siswa' => $validated['edit_alamat_siswa'],
            'jk_siswa' => $request->edit_jk_siswa,
            'id_kelas' => $request->edit_id_kelas,
        ];

        $dataUpdate = $siswa->update($data);

        if (!$user) {
            return back()->with('error', 'Gagal ubah data');
        } else {
            if (!$dataUpdate) {
                return back()->with('error', 'Gagal ubah data');
            }
        }
        return back()->with('message', 'Berhasil ubah data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        $user = User::find($siswa->id_user);
        $userDel = $user->delete();

        if ($userDel) {
            $success = $siswa->delete();
            if ($success) {
                return back()->with('message', 'Berhasil hapus data');
            }
        } else {
            return back()->with('error', 'Gagal hapus data');
        }
    }
}
