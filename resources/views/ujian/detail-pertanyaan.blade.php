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
                    <h3><a href="{{ route('ujian.index') }}" class="text-info fw-bold">
                            Data Ujian
                        </a> {{ $det_nama->nama_ujian }}</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('detail-ujian.add', $det_id->id_ujian) }}"
                                    class="btn icon icon-left btn-success">
                                    <i data-feather="check-circle">
                                    </i> Tambah Data
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped datatable" id="table5">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pertanyaan Ujian</th>
                                <th>Option Jawaban</th>
                                <th>Jawaban Benar</th>
                                <th>Lampiran</th>
                                <th>level</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $loop->iteration }} </td>
                                    <td>{{ $item->pertanyaan_ujian }}</td>
                                    <td>{{ $item->option_ujian }}</td>
                                    <td>{{ $item->jawaban_ujian }}</td>
                                    <td>{{ $item->lampiran }}</td>
                                    <td>{{ $item->level }}</td>
                                    <td>
                                        {{-- <a href="{{ route('ujian.edit', $item->id_ujian) }}"
                                            class="btn icon btn-info rounded-pill" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </a> --}}
                                        <button type="button" class="btn icon btn-danger rounded-pill" title="Hapus Data"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-bs-act="{{ route('detail-ujian.destroy', $item->id) }}"
                                            data-bs-nama="{{ $item->nama_ujian }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                {{-- @dd($item->option_ujian) --}}
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- DELETE MODAL --}}
            <div class="modal fade text-left" id="deleteModal" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel120" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title white" id="myModalLabel120">
                                Konfirmasi
                            </h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form action="/" id="delete-form" method="post">
                            @csrf
                            @method('delete')
                            <div>
                                <br>
                            </div>
                            <div class="text-center">
                                Yakin untuk menghapus pertanyaan ujian?
                                {{-- <strong class="badge border-danger border-1 text-danger" id="del_nama_ujian"> </strong>? --}}
                            </div>
                            <div><br></div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="submit" class="btn btn-danger ms-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Oke</span>
                                </button>
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
            // delForm.find('#del_nama_ujian').text('"' + delButton.attr('data-bs-nama') + '"')
        })
    </script>
@endsection
