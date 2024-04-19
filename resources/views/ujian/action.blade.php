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
                    @if ($action == 'add')
                        <h3>Form Tambah Ujian</h3>
                    @else
                        <h3>Form Edit Ujian</h3>
                    @endif
                </div>
            </div>
        </div>
        <section class="section">

            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" method="post"
                            action="{{ $action == 'add' ? route('ujian.store') : route('ujian.update', $ujian->id_ujian) }}"
                            id="update-form" data-parsley-validate>
                            @csrf
                            @if ($action == 'edit')
                                @method('put')
                            @endif
                            <div class="form-body">
                                <div class="row">
                                    <div
                                        class="{{ auth()->user()->role === 'Guru' ? 'col-md-6 col-12' : 'col-md-12 col-12' }}">
                                        <div class="form-group">
                                            <label for="id_ujian">Id Ujian</label>
                                            <input type="text" id="id_ujian" class="form-control"
                                                value="{{ $action === 'add' ? $id_ujian : $ujian->id_ujian }}"
                                                name="id_ujian" readonly />
                                        </div>
                                    </div>
                                    @if (auth()->user()->role === 'Guru')
                                        <div class="col-md-6 col-12" hidden>
                                            <div class="form-group">
                                                <label for="nip">NIP</label>
                                                <input type="text" id="nip" class="form-control"
                                                    value="{{ $action === 'add' ? $nip->nip : $nip->nip }}" name="id_ujian"
                                                    readonly />
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="nama_ujian" class="form-label">Nama Ujian</label>
                                            <input type="text" id="nama_ujian" class="form-control"
                                                placeholder="cth: UAS" name="nama_ujian"
                                                value="{{ $action === 'add' ? '' : $ujian->nama_ujian }}"
                                                data-parsley-required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="mapel" class="form-label">Mata Pelajaran</label>
                                            @if (auth()->user()->role === 'Guru')
                                                <select id="id_mapel" name="id_mapel" class=" form-select"
                                                    data-parsley-required="true">
                                                    {{-- @foreach ($mapel as $item) --}}
                                                    <option value="{{ $mapel[0]['kode_mapel'] }}" selected readonly>
                                                        {{-- {{ $mapel->fkMapelGuru->nama_mapel }} --}}
                                                        {{ $mapel[0]['nama_mapel'] }}
                                                    </option>
                                                    {{-- @endforeach --}}
                                                </select>
                                            @else
                                                <select id="id_mapel" name="id_mapel" class=" form-select"
                                                    data-parsley-required="true">
                                                    @if ($action == 'add')
                                                        <option value="" selected readonly>Pilih satu</option>
                                                    @else
                                                        <option value="{{ $ujian->kode_mapel }}" selected readonly>
                                                            {{ $ujian->fkMapelUjian->nama_mapel }}</option>
                                                    @endif
                                                    @foreach ($mapel as $item)
                                                        <option value="{{ $item->kode_mapel }}">
                                                            {{ $item->nama_mapel }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="waktu_ujian">Waktu Mulai - Waktu Akhir Ujian</label>
                                            <input type="date" class="form-control flatpickr-range"
                                                placeholder="Pilih waktu" id="waktu_ujian" name="waktu_ujian"
                                                {{ $action === 'add' ? 'data-parsley-required="true"' : '' }} />
                                        </div>
                                    </div>
                                    @if ($action == 'add')
                                        <div class="col-md-6 col-12">
                                            <div class="form-group mandatory">
                                                <label for="id_kelas">Kelas</label>
                                                <select id="id_kelas" name="id_kelas[]"
                                                    class="choices form-select multiple-remove" multiple="multiple"
                                                    data-parsley-required="true">
                                                    @foreach ($kelas as $item)
                                                        <option value="{{ $item->id }}">{{ $item->nama_kelas }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="col-12 d-flex justify-content-start">
                                        <button type="submit" class="btn btn-primary me-1 mb-1">
                                            Submit
                                        </button>
                                        @if ($action == 'add')
                                            <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                                Reset
                                            </button>
                                        @endif
                                        <a href="/ujian" class="btn btn-light-warning me-1 mb-1">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('page-script')
    <script>
        // Delete Modal
        $('#deleteModal').bind('show.bs.modal', event => {
            const delButton = $(event.relatedTarget);
            const delForm = $('form#delete-form');
            delForm.attr('action', delButton.attr('data-bs-act'));
            delForm.find('#del_nama_ujian').text('"' + delButton.attr('data-bs-nama') + '"')
        })
    </script>
    <script>
        // $('#waktu_akhir')
    </script>
@endsection
