<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Str;

class GuruController extends Controller
{
    const inputData = ['nip', 'nama_guru', 'tlp_guru', 'alamat_guru', 'jk_guru', 'id_mapel'];
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mapel = Mapel::all();
        $data = Guru::with('fkMapelGuru')->get();
        return view('guru.index', compact('data', 'mapel'));
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
            'nip' => 'required|max:18',
            'nama_guru' => 'required|string|max:50',
            'tlp_guru' => 'required|max:12',
            'alamat_guru' => 'required|string|max:255',
        ]);

        $username = explode(" ", $data['nama_guru']);
        $dataUser = User::where('username', $username[0])->get()->count();
        $dataUser1 = User::withTrashed()->where('username', $username[0])->get()->count();

        $guru = Guru::where('nip', $data['nip'])->get()->count();
        $guru1 = Guru::withTrashed()->where('nip', $data['nip'])->get()->count();

        if ($guru1 > 0)
            return back()->with('warning', 'NIP sudah terdaftar, Silakan hubungi admin');

        if ($guru > 0)
            return back()->with('warning', 'NIP sudah terdaftar');

        if ($dataUser > 0 || $dataUser1 > 0) {
            $randomString = Str::lower(Str::random(3));
            $randomNumber = Str::random(2, '1234567890');
            $random = $randomString . $randomNumber;

            $user = User::create([
                'name' => $data['nama_guru'],
                'username' => $username[0] . $random,
                'password' => bcrypt($username[0]),
                'role' => 'Guru',
                'stts' => 1
            ]);
        } else {
            $user = User::create([
                'name' => $data['nama_guru'],
                'username' => $username[0],
                'password' => bcrypt($username[0]),
                'role' => 'Guru',
                'stts' => 1
            ]);
        }

        $dataStore = Guru::create([
            'nip' => $data['nip'],
            'nama_guru' => $data['nama_guru'],
            'tlp_guru' => $data['tlp_guru'],
            'alamat_guru' => $data['alamat_guru'],
            'jk_guru' => $request->jk_guru,
            'id_mapel' => $request->id_mapel,
            'id_users' => $user->id
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
    public function show(Guru $guru)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Guru $guru)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'edit_nip' => 'required|max:18',
            'edit_nama_guru' => 'required|string|max:50',
            'edit_tlp_guru' => 'required|max:12',
            'edit_alamat_guru' => 'required|string|max:255',
        ]);

        $user = User::find($guru->id_users);
        $username = explode(" ", $validated['edit_nama_guru']);
        $dataUser = User::where('username', $username[0])->get()->count();
        $dataUser1 = User::withTrashed()->where('username', $username[0])->get()->count();

        $guru = Guru::where('nip', $validated['edit_nip'])->get()->count();
        $guru1 = Guru::withTrashed()->where('nip', $validated['edit_nip'])->get()->count();

        if ($guru1 > 0)
            return back()->with('warning', 'NIP sudah terdaftar, Silakan hubungi admin');

        if ($guru > 0)
            return back()->with('warning', 'NIP sudah terdaftar');

        if ($dataUser > 0 || $dataUser1) {
            return back()->with('warning', 'Username sudah tersedia');
        }

        $user->username = $username[0];
        $user->name = $validated['edit_nama_guru'];
        $userUpdate = $user->save();

        $data = [
            'nip' => $validated['edit_nip'],
            'nama_guru' => $validated['edit_nama_guru'],
            'tlp_guru' => $validated['edit_tlp_guru'],
            'alamat_guru' => $validated['edit_alamat_guru'],
            'jk_guru' => $request->edit_jk_guru,
            'id_mapel' => $request->edit_id_mapel,
        ];

        $dataUpdate = $guru->update($data);

        if (!$userUpdate) {
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
    public function destroy(Guru $guru)
    {
        $user = User::find($guru->id_users);
        $userDel = $user->delete();

        if ($userDel) {
            $success = $guru->delete();
            if ($success) {
                return back()->with('message', 'Berhasil hapus data');
            }
        } else {
            return back()->with('error', 'Gagal hapus data');
        }
    }
}
