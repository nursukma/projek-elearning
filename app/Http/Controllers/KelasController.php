<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Kelas::all();
        return view('kelas.index', compact('data'));
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
            'nama_kelas' => 'required|string|max:50'
        ]);

        $dataStore = Kelas::create($data);

        if (!$dataStore) {
            return back()->with('error', 'Gagal tambah data');
        }
        return back()->with('message', 'Berhasil tambah data');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kelas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama_kelas' => 'required|string|max:50'
        ]);

        $kelas = Kelas::find($id);
        $kelas->nama_kelas = $data['nama_kelas'];
        $dataUpdate = $kelas->save();

        if (!$dataUpdate) {
            return back()->with('error', 'Gagal ubah data');
        }
        return back()->with('message', 'Berhasil ubah data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kelas = Kelas::find($id);
        $del = $kelas->delete();
        if (!$del)
            return back()->with('error', 'Gagal hapus data');
        return back()->with('message', 'Berhasil hapus data');
    }
}