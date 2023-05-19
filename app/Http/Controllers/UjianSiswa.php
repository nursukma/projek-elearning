<?php

namespace App\Http\Controllers;

use App\Models\DetailUjian;
use App\Models\Siswa;
use App\Models\SubjekUjian;
use App\Models\TemporaryNilai;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

class UjianSiswa extends Controller
{
    public $level = 1;

    // public function __construct()
    // {
    //     $this->level = 1;
    // }

    public function index()
    {
        $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');

        $id_user = auth()->user()->id;
        $peserta = Siswa::where('id_user', $id_user)->first();
        $nis_peserta = $peserta->nis;

        // $data = Ujian::with('fkSubjekUjian', 'fkMapelUjian')->whereRelation('fkSubjekUjian', 'nis_peserta', $nis_peserta)
        //     ->get();

        $data = DB::table('ujian')
            ->join('subjek_ujian', 'ujian.id_ujian', '=', 'subjek_ujian.no_ujian')
            ->join('mapel', 'ujian.kode_mapel', '=', 'mapel.kode_mapel')
            ->where('subjek_ujian.nis_peserta', $nis_peserta)
            ->where('ujian.deleted_at', '=', null)
            // ->where($currentDateTime, '<', 'ujian.waktu_akhir')
            ->where(function ($query) use ($currentDateTime) {
                $query->where('waktu_mulai', '<=', $currentDateTime)
                    ->where('waktu_akhir', '>=', $currentDateTime);
            })
            ->get();

        // dd($data);

        return view('ujian.siswa-index', compact('data'));
    }

    public function create($id)
    {
        // $data = Ujian::with('fkDetUjianUjian')->where('ujian.id_ujian', $id)->get();
        $level = session()->get('level');

        $ujian = Ujian::where('id_ujian', $id)->first();
        $max_level = DB::table('detail_ujian')->max('level');

        if (session()->has('level')) {
            $data =  DB::table('ujian')
                ->join('detail_ujian', 'ujian.id_ujian', '=', 'detail_ujian.id_ujian')
                ->where('ujian.id_ujian', $id)
                ->where('detail_ujian.deleted_at', '=', null)
                ->where('detail_ujian.level', '=', $level)
                // ->orderBy('level')
                // ->groupBy('level')
                ->get();
        } else {
            $data =  DB::table('ujian')
                ->join('detail_ujian', 'ujian.id_ujian', '=', 'detail_ujian.id_ujian')
                ->where('ujian.id_ujian', $id)
                ->where('detail_ujian.deleted_at', '=', null)
                ->where('detail_ujian.level', '=', $this->level)
                // ->orderBy('level')
                // ->groupBy('level')
                ->get();
        }

        // dd($level);
        // session()->put('nilai', 0);
        // session()->put('soal', count($data));
        return view('ujian.siswa-action', compact('data', 'ujian', 'level', 'max_level'));
    }

    public function store(Request $request, $id)
    {
        if (session()->has('level')) {
            $level = session()->get('level');
        } else {
            $level = $this->level;
        }

        $id_user = auth()->user()->id;
        $peserta = Siswa::where('id_user', $id_user)->first();
        $nis_peserta = $peserta->nis;


        $data =  DB::table('detail_ujian')
            ->where('detail_ujian.id_ujian', $id)
            ->where('detail_ujian.deleted_at', '=', null)
            ->where('detail_ujian.level', '=', $level)
            ->get();



        $temp_nilai = TemporaryNilai::where('id_user', $id_user)->first();
        if ($temp_nilai) {
            $betul = $temp_nilai->betul;
            $jmlData = $temp_nilai->soal + count($data);
        } else {
            $betul = 0;
            $jmlData = count($data);
        }



        foreach ($data as $key => $value) {
            if ($value->jawaban_ujian == $request->input('jawaban_ujian' . $key)) {
                $betul += 1;
                // session()->put('betul', $betul);
                // array_push($coba, $request->input('jawaban_ujian' . $key));
            }
        }

        $nilai = $betul / $jmlData * 100;

        $max_level = DB::table('detail_ujian')->max('level');
        if ($request->session()->get('level') == $max_level) {
            Session::forget('level');
            // Session::forget('betul');

            $upnilai =  SubjekUjian::where('nis_peserta', '=', $nis_peserta)->where('no_ujian', '=', $id)->update(['nilai' => $nilai]);
            if ($upnilai) {
                if ($temp_nilai) {
                    $temp_nilai->delete();
                }
            }

            // $this->level = 1;
            return redirect('/daftar-ujian')->with('message', 'Terima kasih telah mengerjakan ujian');
        } else {
            if ($nilai >= 50) {
                $level += 1;
                $request->session()->put('level', $level);
                // $request->session()->put('betul', $betul);

                if (!$temp_nilai) {
                    TemporaryNilai::create(['id_user' => $id_user, 'soal' => $jmlData, 'betul' => $betul]);
                } else {
                    TemporaryNilai::where('id_user', '=', $id_user)->update(['soal' => $jmlData, 'betul' => $betul]);
                }

                return redirect('/daftar-ujian/pengerjaan/' . $id)->with('message', 'Selamat lanjut level');
            } else {
                // $this->level = 1;
                return redirect('/daftar-ujian/pengerjaan/' . $id)->with('error', 'Maaf gagal lanjut level');
            }
        }
        // dd($this->level);
    }

    public function deleteLevel($id)
    {
        Session::forget('level');
        return redirect('/daftar-ujian/pengerjaan/' . $id);
    }

    public function showNilai($id)
    {
        // $id = auth()->user()->id;
        $peserta = Siswa::where('id_user', $id)->first();
        $nis_peserta = $peserta->nis;

        // $subjek_ujian = SubjekUjian::where('nis_peserta', $nis_peserta)->get();
        $data = DB::table('subjek_ujian')
            ->join('ujian', 'ujian.id_ujian', '=', 'subjek_ujian.no_ujian')
            ->join('mapel', 'ujian.kode_mapel', '=', 'mapel.kode_mapel')
            ->select('mapel.nama_mapel', 'mapel.kode_mapel', 'subjek_ujian.*', 'ujian.nama_ujian')
            ->where('subjek_ujian.nis_peserta', $nis_peserta)
            ->where('ujian.deleted_at', '=', null)
            ->get();

        // dd($data);
        return view('ujian.siswa-nilai', compact('data'));
    }
}
