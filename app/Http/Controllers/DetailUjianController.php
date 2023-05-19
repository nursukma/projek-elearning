<?php

namespace App\Http\Controllers;

use App\Models\DetailUjian;
use App\Models\TemporaryFile;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DetailUjianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $data = DetailUjian::where('id_ujian', $id)->get();
        $det_nama = Ujian::select('nama_ujian')->where('id_ujian', $id)->first();

        $det_id = Ujian::select('id_ujian')->where('id_ujian', $id)->first();

        // if ($det_id)
        return view('ujian.detail-pertanyaan', compact('data', 'det_id', 'det_nama'));

        // return view('ujian.detail-pertanyaan', compact('data', 'det_nama'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $temp_file = TemporaryFile::where('folder', $request->lampiran)->first();

        $explode_option =  explode(",", $request->option_jawaban);
        $option_jawaban = json_encode($explode_option);

        // dd($option_jawaban);

        if ($temp_file) {
            Storage::copy('ujian/tmp/' . $temp_file->folder . '/' . $temp_file->file, 'ujian/lampiran/' . $temp_file->folder . '/' . $temp_file->file);
            $dataStore = DetailUjian::create([
                'id_ujian' => $request->id_ujian,
                'pertanyaan_ujian' => $request->pertanyaan_ujian,
                'option_ujian' => $option_jawaban,
                'jawaban_ujian' => $request->jawaban_ujian,
                'level' => $request->level,
                'lampiran' => $temp_file->folder . '/' . $temp_file->file,
            ]);
            Storage::deleteDirectory('ujian/tmp/' . $temp_file->folder);
            $temp_file->delete();
        } else {
            $dataStore = DetailUjian::create([
                'id_ujian' => $request->id_ujian,
                'pertanyaan_ujian' => $request->pertanyaan_ujian,
                'option_ujian' => $option_jawaban,
                'jawaban_ujian' => $request->jawaban_ujian,
                'level' => $request->level,
                'lampiran' => '',
            ]);
        }

        if (!$dataStore)
            return redirect('/detail-ujian/index/' . $request->id_ujian)->with('error', "Gagal menambahkan detail ujian");

        return redirect('/detail-ujian/index/' . $request->id_ujian)->with('message', "Berhasil menambahkan detail ujian");
    }

    /**
     * Display the specified resource.
     */
    public function show(DetailUjian $detailUjian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DetailUjian $detailUjian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DetailUjian $detailUjian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DetailUjian $detailUjian)
    {
        $del = $detailUjian->delete();
        Storage::deleteDirectory('ujian/lampiran/' . $detailUjian->lampiran);
        if (!$del)
            return back()->with('error', 'Gagal hapus data');
        return back()->with('message', 'Berhasil hapus data');
    }

    public function add(Request $request, $id)
    {
        $action = 'add';
        $id_user = auth()->user()->id;

        $ujian = Ujian::where('id_ujian', $id)->first();

        return view('ujian.action-pertanyaan', compact('action', 'ujian'));
    }

    public function tmpUpload(Request $request)
    {
        if ($request->hasFile('lampiran')) {
            $image = $request->file('lampiran');
            $file_name = $image->getClientOriginalName();

            $folder = uniqid('ujian', true);
            // $image->storeAs('ujian/tmp', $folder);
            $image->storeAs('ujian/tmp/' . $folder, $file_name);

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
            Storage::deleteDirectory('ujian/tmp/' . $temp_file->folder);
            $temp_file->delete();
            return response('');
        }
    }
}
