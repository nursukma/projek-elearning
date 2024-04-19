<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use ZipArchive;

class MateriSiswa extends Controller
{
    public function index()
    {
        $data = Materi::with('fkMapelMateri')->get();
        return view('materi.siswa-index', compact('data'));
    }

    public function downloadPDF($folder, $filename)
    {
        $filePath = "materi/lampiran/{$folder}/{$filename}";
        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        if (Storage::exists($filePath)) {
            $mime_type = Storage::mimeType($filePath);

            return response()->download(storage_path("app/public/{$filePath}"), $filename, ['Content-Type' => $mime_type]);
        } else {
            return abort(404);
        }
    }
}
