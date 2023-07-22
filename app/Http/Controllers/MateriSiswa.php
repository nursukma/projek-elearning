<?php

namespace App\Http\Controllers;

use App\Models\Materi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class MateriSiswa extends Controller
{
    public function index()
    {
        $data = Materi::with('fkMapelMateri')->get();
        return view('materi.siswa-index', compact('data'));
    }

    public function downloadPDF($file)
    {
        $filePath = public_path('storage/materi/lampiran/' . $file);
        $headers = [
            'Content-Type' => 'application/pdf',
        ];

        $files = scandir($filePath);

        // Filter out "." and ".." directories from the list
        $files = array_diff($files, ['.', '..']);

        // $files sekarang berisi daftar nama file dalam direktori yang ditentukan
        foreach ($files as $file1) {
            $dir = $filePath . '/' . $file1;
            $mime_type = File::mimeType($dir);

            // Generate the response to open the file in a new blank tab or window
            $response = Response::make(file_get_contents($dir), 200);
            $response->header('Content-Type', $mime_type);
            $response->header('Content-Disposition', 'inline; filename="' . $file1 . '"');
            return $response;
            // return Storage::download($file1, $dir, $headers);
            // return Response::download($dir, $file1, $headers);
        }
    }
}