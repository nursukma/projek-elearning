<?php

namespace App\Http\Controllers;

use App\Models\Mapel;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Mapel::all();
        return view('mapel.index', compact('data'));
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
            'kode_mapel' => 'required|string|max:5',
            'nama_mapel' => 'required|string|max:25'
        ]);

        $mapel = Mapel::where('kode_mapel', $data['kode_mapel'])->get()->count();
        $mapel1 = Mapel::withTrashed()->where('kode_mapel', $data['kode_mapel'])->get()->count();

        if ($mapel1 > 0)
            return back()->with('warning', 'Kode mata pelajaran sudah tersedia, Silakan hubungi admin');

        if ($mapel > 0)
            return back()->with('warning', 'Kode mata pelajaran sudah tersedia');

        $dataStore = Mapel::create($data);

        if (!$dataStore) {
            return back()->with('error', 'Gagal tambah data');
        }
        return back()->with('message', 'Berhasil tambah data');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $mapel = Mapel::where('kode_mapel', $id)->get();
        return response()->json($mapel);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mapel $mapel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mapel $mapel)
    {
        $data = $request->validate([
            'kode_mapel' => 'required|string|max:5',
            'nama_mapel' => 'required|string|max:25'
        ]);

        $mapel = Mapel::where('kode_mapel', $data['kode_mapel'])->get()->count();
        $mapel1 = Mapel::withTrashed()->where('kode_mapel', $data['kode_mapel'])->get()->count();

        if ($mapel1 > 0)
            return back()->with('warning', 'Kode mata pelajaran sudah tersedia, Silakan hubungi admin');

        if ($mapel > 0)
            return back()->with('warning', 'Kode mata pelajaran sudah tersedia');

        $dataUpdate = $mapel->update($data);

        if (!$dataUpdate) {
            return back()->with('error', 'Gagal ubah data');
        }
        return back()->with('message', 'Berhasil ubah data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mapel $mapel)
    {
        $del = $mapel->delete();
        if (!$del) {
            return back()->with('error', 'Gagal hapus data');
        }
        return back()->with('message', 'Berhasil hapus data');
    }
}
