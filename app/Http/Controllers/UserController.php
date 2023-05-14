<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::where('role', '!=', 'Super Admin')->get();
        return view('user.index', compact('data'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate(['username' => 'required|max:10']);
        $user = User::find($id);

        if ($request->password !== '') {
            $user->password = bcrypt($request->password);
        }

        $user->username = $validated['username'];
        $updateUser = $user->save();

        if (!$updateUser)
            return back()->with('error', 'Gagal ubah data');
        return back()->with('message', 'Berhasil ubah data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if ($user->role == 'Siswa') {
            $data = Siswa::where('id_user', $id);
        } else {
            $data = Guru::where('id_users', $id);
        }

        $delUser = $user->delete();
        if (!$delUser) {
            return back()->with('error', 'Gagal hapus data');
        } else {
            $delData = $data->delete();
            if (!$delData) {
                return back()->with('error', 'Gagal hapus data');
            } else {
                return back()->with('message', 'Berhasil hapus data');
            }
        }
    }

    public function profile(Request $request)
    {
        $validated = $request->validate(['username' => 'required|max:10']);
        $user = User::find(auth()->user()->id);

        $dupUser = User::where('username', $request->username)->get()->count();
        if ($dupUser > 0)
            return back()->with('warning', 'Username telah tersedia');

        $user->username = $validated['username'];
        if ($request->password !== '') {
            $user->password = bcrypt($request->password);
        }

        $user->username = $request->username;
        $updateUser = $user->save();

        if (!$updateUser)
            return back()->with('error', 'Gagal memperbarui profil');
        return back()->with('message', 'Berhasil memperbarui profil');
    }

    public function ban($id)
    {
        $data = User::find($id);
        if ($data->stts == 1) {
            $data->stts = 0;
            $updateData = $data->save();
            if (!$updateData)
                return back()->with('error', 'Gagal menonaktifkan user');
            return back()->with('message', 'Berhasil menonaktifkan user');
        } else {
            $data->stts = 1;
            $updateData = $data->save();
            if (!$updateData)
                return back()->with('error', 'Gagal mengaktifkan user');
            return back()->with('message', 'Berhasil mengaktifkan user');
        }
    }
}
