@extends('layouts.default')

@section('page-style')
@endsection

@section('content')
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Ujian {{ $ujian->nama_ujian }} {{ count($data) > 0 ? 'Level ' . $data[0]->level : '' }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                Level maksimal {{ $max_level }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">

            @if (count($data) > 0)
                <form class="form" action="{{ route('daftar-ujian.store', $ujian->id_ujian) }}" method="post"
                    id="action-form" data-parsley-validate>
                    @csrf
                    @foreach ($data as $key => $item)
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    {{ $item->pertanyaan_ujian }}
                                </h5>
                                @if ($item->lampiran)
                                    <img class="img-fluid" style="width: 150px" height="120px"
                                        src="{{ asset('/storage/ujian/lampiran/' . $item->lampiran) }}" alt="Lampiran" />
                                @endif
                                <p class="card-text">
                                <fieldset>
                                    <label class="form-label">
                                        Opsi Jawaban
                                    </label>
                                    @foreach (json_decode($item->option_ujian) as $option_ujian)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio"
                                                name="jawaban_ujian{{ $key }}"
                                                id="jawaban_ujian{{ $key }}" value="{{ $option_ujian }}" />
                                            <label class="form-check-label form-label" for="jk_guru">
                                                {{ $option_ujian }}
                                            </label>
                                            {{-- {{ json_encode($item->option_ujian) }} --}}
                                        </div>
                                    @endforeach
                                </fieldset>
                                </p>
                            </div>
                        </div>
                    @endforeach
                    <div class="col-12 d-flex justify-content-between">
                        <button type="submit" class="btn btn-light-primary">Submit</button>
                        {{-- @if (session()->has('level'))
                            @if (session()->get('level') > 1)
                                <a href="{{ route('daftar-ujian.create', $ujian->id_ujian) }}"
                                    class="btn btn-light-warning">
                                    Kembali
                                </a>
                            @endif
                        @endif --}}
                    </div>
                </form>
            @else
                <div class="alert alert-info">
                    <i class="bi bi-exclamation-triangle"></i> Belum ada soal tersedia, Silakan hubungi pengampu atau admin.
                </div>
            @endif
        </section>
    </div>
@endsection

@section('page-script')
    <script></script>
@endsection
