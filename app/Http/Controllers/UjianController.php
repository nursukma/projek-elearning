<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Kelas;
use App\Models\Mapel;
use App\Models\Siswa;
use App\Models\SubjekUjian;
use App\Models\Ujian;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UjianController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('role:Super Admin|Guru');
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Ujian::with('fkUjianGuru', 'fkMapelUjian')->get();
        $waktu_ujian = [];
        for ($i = 0; $i < count($data); $i++) {
            $waktu_mulai = $data[$i]->waktu_mulai;
            $waktu_akhir = $data[$i]->waktu_akhir;
            //     $waktu_ujian = $selisih->format('%h:%i');
            $to = Carbon::createFromFormat('Y-m-d H:s:i', $waktu_mulai);
            $from = Carbon::createFromFormat('Y-m-d H:s:i', $waktu_akhir);
            $waktu_ujian[$i] = $to->diffInMinutes($from);
        }
        // dd($waktu_ujian);
        return view('ujian.index', compact('data', 'waktu_ujian'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $action = 'add';
        $id_user = auth()->user()->id;

        $randomString = Str::upper(Str::random(3));
        // $randomNumber = rand(0, getrandmax());
        $tglSekarang = Carbon::now()->format('dmY');
        $id_ujian = "UJ" . $randomString  . $tglSekarang;

        if (auth()->user()->role === 'Guru') {
            $mapel = Mapel::with('fkMapelGuru')
                ->whereHas('fkMapelGuru', function (Builder $query) use ($id_user) {
                    $query->where('id_users', '=',  $id_user);
                })
                ->get()
                ->toArray();
        } else {
            $mapel = Mapel::all();
        }

        $kelas = Kelas::all();

        // dd($mapel);
        return view('ujian.action', compact('action', 'kelas', 'mapel', 'id_ujian'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $id_kelas = $request->id_kelas;

        $id_user = auth()->user()->id;
        $guru = Guru::select('nip')->where('id_users', $id_user)->first();

        $waktu_ujian = explode(" to ", $request->waktu_ujian);

        $dataStore = Ujian::create([
            'id_ujian' => $request->id_ujian,
            'kode_mapel' => $request->id_mapel,
            'nama_ujian' => $request->nama_ujian,
            'waktu_mulai' => $waktu_ujian[0],
            'waktu_akhir' => $waktu_ujian[1],
            'nip' => $guru->nip,
            // 'id_kelas' => $id_kelas[$i]
        ]);

        if (!$dataStore)
            return back()->with('error', 'Gagal tambah data');

        for ($i = 0; $i < count($id_kelas); $i++) {
            $siswa = Siswa::where('id_kelas', $id_kelas[$i])->get();
            for ($j = 0; $j < count($siswa); $j++) {
                $subjek_ujian = SubjekUjian::create([
                    'no_ujian' => $dataStore['id_ujian'],
                    'nis_peserta' => $siswa[$j]->nis,
                    'nilai' => 0
                ]);
                if (!$subjek_ujian)
                    return back()->with('error', 'Gagal tambah data');
            }
        };
        return redirect('/ujian')->with('message', 'Berhasil tambah data');
        // dd($guru->nip);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ujian $ujian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ujian $ujian)
    {
        $action = 'edit';
        return view('ujian.action', compact('action', 'ujian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ujian $ujian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ujian $ujian)
    {
        //
    }
}
