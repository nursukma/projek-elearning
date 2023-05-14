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
                    <h3>Data Mata Pelajaran</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a class="btn icon icon-left btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
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
                                <th>Kode Pelajaran</th>
                                <th>Nama Pelajaran</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }} </td>
                                    <td>{{ $item->kode_mapel }}</td>
                                    <td>{{ $item->nama_mapel }}</td>
                                    <td>
                                        <button type="button" class="btn icon btn-info rounded-pill" data-bs-toggle="modal"
                                            data-bs-target="#editModal" title="Ubah Data" id="edit"
                                            data-bs-toggle="modal" data-bs-target="#editModal"
                                            data-bs-act="{{ route('mapel.update', $item->kode_mapel) }}"
                                            data-bs-kode_mapel="{{ $item->kode_mapel }}"
                                            data-bs-nama_mapel="{{ $item->nama_mapel }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn icon btn-danger rounded-pill" title="Hapus Data"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-bs-act="{{ route('mapel.destroy', $item->kode_mapel) }}"
                                            data-bs-kode_mapel="{{ $item->kode_mapel }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- ADD MODAL --}}
            <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33">
                                Form Tambah Data
                            </h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form class="form" action="{{ route('mapel.store') }}" method="POST"
                            enctype="multipart/form-data" data-parsley-validate>
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="kode_mapel" class="form-label">Kode Pelajaran</label>
                                            <input type="text" id="kode_mapel" class="form-control"
                                                placeholder="cth: MTK" name="kode_mapel" data-parsley-required="true" />
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_mapel" class="form-label">Nama Pelajaran</label>
                                            <input type="text" id="nama_mapel" class="form-control"
                                                placeholder="cth: Matematika" name="nama_mapel"
                                                data-parsley-required="true" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="submit" class="btn btn-primary ms-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Simpan</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- EDIT MODAL --}}
            <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel33">
                                Form Edit Data
                            </h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form class="form" action="/" method="post" id="update-form" data-parsley-validate>
                            @csrf
                            @method('put')
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="kode_mapel" class="form-label">Kode Pelajaran</label>
                                            <input type="text" id="kode_mapel" class="form-control"
                                                placeholder="cth: MTK" name="kode_mapel" data-parsley-required="true" />
                                        </div>
                                        <div class="form-group">
                                            <label for="nama_mapel" class="form-label">Nama Pelajaran</label>
                                            <input type="text" id="nama_mapel" class="form-control"
                                                placeholder="cth: Matematika" name="nama_mapel"
                                                data-parsley-required="true" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                                <button type="submit" class="btn btn-primary ms-1">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Simpan</span>
                                </button>
                            </div>
                        </form>
                    </div>
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
                                Yakin untuk menghapus data mata pelajaran dengan kode
                                <strong class="badge border-danger border-1 text-danger" id="del_kode_mapel"> </strong>?
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
        // Edit Modal
        $('#editModal').bind('show.bs.modal', event => {
            const updateForm = $('form#update-form');
            const updateButton = $(event.relatedTarget);

            updateForm.attr('action', updateButton.attr('data-bs-act'));
            updateForm.find('#nama_mapel').val(updateButton.attr('data-bs-nama_mapel'));
            updateForm.find('#kode_mapel').val(updateButton.attr('data-bs-kode_mapel'));
        }).bind('hide.bs.modal', e => {
            const updateForm = $('form#update-form');
            updateForm.attr('action', '/');
            updateForm[0].reset();
        });

        // Delete Modal
        $('#deleteModal').bind('show.bs.modal', event => {
            const delButton = $(event.relatedTarget);
            const delForm = $('form#delete-form');
            delForm.attr('action', delButton.attr('data-bs-act'));
            delForm.find('#del_kode_mapel').text('"' + delButton.attr('data-bs-kode_mapel') + '"')
        })
    </script>
@endsection
