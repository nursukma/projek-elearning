<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Materi;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Builder;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        if (auth()->user()->role === 'Admin') {
            $mapel = Mapel::all();
            $data = Materi::with('fkMapelMateri')->get();
            return view('materi.index', compact('data', 'mapel'));
        } else {
            $guru = Guru::with('fkMapelGuru')->where('id_users', auth()->user()->id)->first();
            $id_user = $guru->id_users;
            $mapel = Mapel::where('kode_mapel', $guru->id_mapel)->first();
            $data = Materi::where('kode_mapel', '=',  $mapel->kode_mapel)->get();
            return view('materi.index', compact('data', 'mapel', 'guru'));
        }
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
        $temp_file = TemporaryFile::where('folder', $request->lampiran)->first();

        $data = $request->validate([
            'deskripsi' => 'required',
            'lampiran' => 'required',
            'id_mapel' => 'required',
        ]);

        $dataStore = Materi::create([
            'kode_mapel' => $data['id_mapel'],
            'berkas' => $data['lampiran'],
            'deskripsi' => $data['deskripsi'],
        ]);

        if (!$dataStore) {
            return back()->with('error', 'Gagal tambah data');
        }

        Storage::copy('materi/tmp/' . $temp_file->folder . '/' . $temp_file->file, 'materi/lampiran/' . $temp_file->folder . '/' . $temp_file->file);
        Storage::deleteDirectory('materi/tmp/' . $temp_file->folder);
        $temp_file->delete();

        return back()->with('message', 'Berhasil tambah data');
    }

    /**
     * Display the specified resource.
     */
    public function show(Materi $materi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Materi $materi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Materi $materi)
    {
        $temp_file = TemporaryFile::where('folder', $request->lampiran)->first();
        Storage::deleteDirectory('materi/lampiran/' . $materi->berkas);

        $data = $request->validate([
            'deskripsi' => 'required',
            'lampiran' => 'required',
            'id_mapel' => 'required',
        ]);

        $up = $materi->update([
            'kode_mapel' => $data['id_mapel'],
            'berkas' => $data['lampiran'],
            'deskripsi' => $data['deskripsi'],
        ]);

        if (!$up) {
            return back()->with('error', 'Gagal ubah data');
        }

        Storage::copy('materi/tmp/' . $temp_file->folder . '/' . $temp_file->file, 'materi/lampiran/' . $temp_file->folder . '/' . $temp_file->file);
        Storage::deleteDirectory('materi/tmp/' . $temp_file->folder);
        $temp_file->delete();

        return back()->with('message', 'Berhasil ubah data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Materi $materi)
    {
        $del = $materi->delete();
        Storage::deleteDirectory('materi/lampiran/' . $materi->berkas);
        if (!$del)
            return back()->with('error', 'Gagal hapus data');
        return back()->with('message', 'Berhasil hapus data');
    }

    public function tmpUpload(Request $request)
    {
        if ($request->hasFile('lampiran')) {
            $image = $request->file('lampiran');
            $file_name = $image->getClientOriginalName();

            $folder = uniqid('materi', true);
            // $image->storeAs('ujian/tmp', $folder);
            $image->storeAs('materi/tmp/' . $folder, $file_name);

            TemporaryFile::create([
                'folder' => $folder,
                'file' => $file_name
            ]);
            return $folder;
        }
        return back()->with('error', 'Gagal');
    }

    public function tmpDelete(Request $request)
    {
        $temp_file = TemporaryFile::where('folder', $request->getContent())->first();
        if ($temp_file) {
            Storage::deleteDirectory('materi/tmp/' . $temp_file->folder);
            $temp_file->delete();
            return response('');
        }
    }
}
