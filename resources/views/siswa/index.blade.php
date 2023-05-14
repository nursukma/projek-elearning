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
                    <h3>Data Siswa</h3>
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
                                <th>nis</th>
                                <th>Nama</th>
                                <th>No Telepon</th>
                                <th>Alamat</th>
                                <th>Jenis Kelamin</th>
                                <th>Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }} </td>
                                    <td>{{ $item->nis }}</td>
                                    <td>{{ $item->nama_siswa }}</td>
                                    <td>{{ $item->tlp_siswa }}</td>
                                    <td>{{ $item->alamat_siswa }}</td>
                                    <td>{{ $item->jk_siswa }}</td>
                                    <td>{{ $item->fkSiswaKelas->nama_kelas }}</td>
                                    <td>
                                        <button type="button" class="btn icon btn-info rounded-pill" data-bs-toggle="modal"
                                            data-bs-target="#editModal" title="Ubah Data" id="edit"
                                            data-bs-toggle="modal" data-bs-target="#editModal"
                                            data-bs-act="{{ route('siswa.update', $item->nis) }}"
                                            data-bs-nis="{{ $item->nis }}" data-bs-nama_siswa="{{ $item->nama_siswa }}"
                                            data-bs-tlp_siswa=" {{ $item->tlp_siswa }}"
                                            data-bs-alamat_siswa="{{ $item->alamat_siswa }}"
                                            data-bs-jk_siswa="{{ $item->jk_siswa }}"
                                            data-bs-kelas="{{ $item->id_kelas }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn icon btn-danger rounded-pill" title="Hapus Data"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-bs-act="{{ route('siswa.destroy', $item->nis) }}"
                                            data-bs-nama="{{ $item->nama_siswa }}">
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
                        <form class="form" action="{{ route('siswa.store') }}" method="POST"
                            enctype="multipart/form-data" data-parsley-validate>
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="nis" class="form-label">NIS</label>
                                            <input type="text" onkeypress="return isNumberKey(event);" id="nis"
                                                class="form-control" placeholder="cth: 1232321" name="nis"
                                                onwheel="return false;" data-parsley-required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="nama_siswa" class="form-label">Nama Lengkap </label>
                                            <input type="text" id="nama_siswa" class="form-control"
                                                placeholder="cth: Nur Sukma Pandawa" name="nama_siswa"
                                                data-parsley-required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="alamat_siswa" class="form-label">Alamat Lengkap</label>
                                            <input type="text" id="alamat_siswa" class="form-control"
                                                placeholder="cth: Jl. Malang no 22" name="alamat_siswa"
                                                data-parsley-required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="tlp_siswa" class="form-label">No Telepon</label>
                                            <input type="text" onkeypress="return isNumberKey(event);" id="tlp_siswa"
                                                class="form-control" name="tlp_siswa" placeholder="cth: 082232326433"
                                                data-parsley-required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <fieldset>
                                                <label class="form-label">
                                                    Jenis Kelamin
                                                </label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="jk_siswa"
                                                        id="jk_siswa" value="Laki-laki" data-parsley-required="true" />
                                                    <label class="form-check-label form-label" for="jk_siswa">
                                                        Laki-laki
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="jk_siswa"
                                                        id="jk_siswa" value="Perempuan" data-parsley-required="true" />
                                                    <label class="form-check-label form-label" for="jk_siswa">
                                                        Perempuan
                                                    </label>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="mapel" class="form-label">Kelas</label>
                                            <select id="id_kelas" name="id_kelas" class=" form-select"
                                                data-parsley-required="true">
                                                <option value="" selected disabled>Pilih satu</option>
                                                @foreach ($kelas as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->nama_kelas }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                {{-- <button id="toast-success" class="btn btn-outline-primary btn-lg btn-block"> --}}
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
            <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel33" aria-hidden="true">
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
                                            <label for="nis" class="form-label">NIS</label>
                                            <input type="text" onkeypress="return isNumberKey(event);" id="nis"
                                                class="form-control" placeholder="cth: 1232321" name="edit_nis"
                                                onwheel="return false;" data-parsley-required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="nama_siswa" class="form-label">Nama Lengkap </label>
                                            <input type="text" id="nama_siswa" class="form-control"
                                                placeholder="cth: Nur Sukma Pandawa" name="edit_nama_siswa"
                                                data-parsley-required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="alamat_siswa" class="form-label">Alamat Lengkap</label>
                                            <input type="text" id="alamat_siswa" class="form-control"
                                                placeholder="cth: Jl. Malang no 22" name="edit_alamat_siswa"
                                                data-parsley-required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="tlp_siswa" class="form-label">No Telepon</label>
                                            <input type="text" onkeypress="return isNumberKey(event);" id="tlp_siswa"
                                                class="form-control" name="edit_tlp_siswa"
                                                placeholder="cth: 082232326433" data-parsley-required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <fieldset>
                                                <label class="form-label">
                                                    Jenis Kelamin
                                                </label>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="edit_jk_siswa"
                                                        id="lk" value="Laki-laki" data-parsley-required="true" />
                                                    <label class="form-check-label form-label" for="jk_siswa">
                                                        Laki-laki
                                                    </label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="edit_jk_siswa"
                                                        id="pr" value="Perempuan" data-parsley-required="true" />
                                                    <label class="form-check-label form-label" for="jk_siswa">
                                                        Perempuan
                                                    </label>
                                                </div>
                                            </fieldset>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="mapel" class="form-label">Kelas</label>
                                            <select id="edit_id_kelas" name="edit_id_kelas" class=" form-select"
                                                data-parsley-required="true">
                                                <option value="" selected disabled>Pilih satu</option>
                                                @foreach ($kelas as $item)
                                                    <option value="{{ $item->id }}">
                                                        {{ $item->nama_kelas }}
                                                    </option>
                                                @endforeach
                                            </select>
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
                                Yakin untuk menghapus data siswa dan informasi login dengan nama
                                <strong class="badge border-danger border-1 text-danger" id="del_nama_siswa"> </strong>?
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
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode
            return !(charCode > 31 && (charCode < 48 || charCode > 57));
        }
    </script>

    <script>
        // Edit Modal
        $('#editModal').bind('show.bs.modal', event => {
            const updateForm = $('form#update-form');
            const updateButton = $(event.relatedTarget);

            updateForm.attr('action', updateButton.attr('data-bs-act'));
            updateForm.find('#nis').val(updateButton.attr('data-bs-nis'));
            updateForm.find('#nama_siswa').val(updateButton.attr('data-bs-nama_siswa'));
            updateForm.find('#tlp_siswa').val(updateButton.attr('data-bs-tlp_siswa'));
            updateForm.find('#alamat_siswa').val(updateButton.attr('data-bs-alamat_siswa'));
            if (updateButton.attr('data-bs-jk_siswa') === 'Laki-laki') {
                updateForm.find('#lk').val(updateButton.attr('data-bs-jk_siswa')).attr(
                    'checked', 'checked');
            } else {
                updateForm.find('#pr').val(updateButton.attr('data-bs-jk_siswa')).attr(
                    'checked', 'checked');
            }
            updateForm.find('#edit_id_kelas').val(updateButton.attr('data-bs-kelas')).attr(
                'selected', 'selected');;
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
            delForm.find('#del_nama_siswa').text('"' + delButton.attr('data-bs-nama') + '"')
        })
    </script>
@endsection
