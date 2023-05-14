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
                    <h3>Data Ujian</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('ujian.create') }}" class="btn icon icon-left btn-success">
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
                                <th>Nama Ujian</th>
                                <th>Mata Pelajaran</th>
                                <th>Waktu Ujian</th>
                                {{-- <th>Sisa Waktu Ujian</th> --}}
                                <th>Pengampu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $loop->iteration }} </td>
                                    <td>{{ $item->nama_ujian }}</td>
                                    <td>{{ $item->fkMapelUjian->nama_mapel }}</td>
                                    <td>{{ $waktu_ujian[$key] }} menit</td>
                                    {{-- <td>{{ $item->waktu_ujian }}</td> --}}
                                    <td>{{ $item->fkUjianGuru->nama_guru }}</td>
                                    {{-- <td>{{ $item->fkUjianKelas->nama_kelas }}</td> --}}
                                    <td>
                                        <a href="{{ route('ujian.edit', $item->id_ujian) }}"
                                            class="btn icon btn-info rounded-pill">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        {{-- <button type="button" class="btn icon btn-info rounded-pill" data-bs-toggle="modal"
                                            data-bs-target="#editModal" title="Ubah Data" id="edit"
                                            data-bs-toggle="modal" data-bs-target="#editModal"
                                            data-bs-act="{{ route('guru.update', $item->nip) }}"
                                            data-bs-nip="{{ $item->nip }}" data-bs-nama_guru="{{ $item->nama_guru }}"
                                            data-bs-tlp_guru=" {{ $item->tlp_guru }}"
                                            data-bs-alamat_guru="{{ $item->alamat_guru }}"
                                            data-bs-jk_guru="{{ $item->jk_guru }}" data-bs-mapel="{{ $item->id_mapel }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn icon btn-danger rounded-pill" title="Hapus Data"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-bs-act="{{ route('guru.destroy', $item->id_ujian) }}"
                                            data-bs-nama="{{ $item->nama_ujian }}">
                                            <i class="bi bi-trash"></i>
                                        </button> --}}
                                    </td>
                                </tr>
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
                                Yakin untuk menghapus data ujian dengan nama ujian
                                <strong class="badge border-danger border-1 text-danger" id="del_nama_ujian"> </strong>?
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
            delForm.find('#del_nama_ujian').text('"' + delButton.attr('data-bs-nama') + '"')
        })
    </script>
@endsection
