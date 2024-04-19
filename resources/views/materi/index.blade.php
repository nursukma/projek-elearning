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
                    <h3>Data Materi</h3>
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
                                <th>Mata Pelajaran</th>
                                <th>Deskripsi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }} </td>
                                    <td>{{ $item->fkMapelMateri->nama_mapel }}</td>
                                    <td>{{ $item->deskripsi }}</td>
                                    <td>
                                        <button type="button" class="btn icon btn-info rounded-pill" data-bs-toggle="modal"
                                            data-bs-target="#editModal" title="Ubah Data" id="edit"
                                            data-bs-act="{{ route('materi.update', $item->id) }}"
                                            data-bs-deskripsi="{{ $item->deskripsi }}"
                                            data-bs-mapel="{{ $item->kode_mapel }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn icon btn-danger rounded-pill" title="Hapus Data"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-bs-act="{{ route('materi.destroy', $item->id) }}"
                                            data-bs-mapel="{{ $item->fkMapelMateri->nama_mapel }}">
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
                        <form class="form" action="{{ route('materi.store') }}" method="POST"
                            enctype="multipart/form-data" data-parsley-validate>
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="mapel" class="form-label">Mata Pelajaran</label>
                                            @if (auth()->user()->role == 'Admin')
                                                <select id="id_mapel" name="id_mapel" class=" form-select"
                                                    data-parsley-required="true">
                                                    <option value="" selected disabled>Pilih satu</option>
                                                    @foreach ($mapel as $item)
                                                        <option value="{{ $item->kode_mapel }}">
                                                            {{ $item->nama_mapel }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="text" id="nama_mapel" class="form-control"
                                                    value="{{ $guru->fkMapelGuru->nama_mapel }}" name="nama_mapel"
                                                    data-parsley-required="true" readonly />
                                                <input type="hidden" id="id_mapel" class="form-control"
                                                    value="{{ $guru->fkMapelGuru->kode_mapel }}" name="id_mapel"
                                                    data-parsley-required="true" readonly />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="deskripsi" class="form-label">Deskripsi </label>
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
                                                placeholder="Bisa diisi dengan ringkasan materi atau gambaran umum tentang lampiran yang diunggah"
                                                data-parsley-required="true"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="lampiran" class="form-label">Lampiran (Hanya Boleh PDF)</label>
                                            <input type="file" class="image-preview-filepond" name="lampiran"
                                                id="lampiran" data-max-file-size="5MB" data-parsley-required="true" />
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
                                <button type="submit" class="btn btn-primary ms-1" id="submit-button">
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
                                Form Tambah Data
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
                                            <label for="mapel" class="form-label">Mata Pelajaran</label>
                                            @if (auth()->user()->role == 'Admin')
                                                <select id="edit_id_mapel" name="id_mapel" class=" form-select"
                                                    data-parsley-required="true">
                                                    <option value="" selected disabled>Pilih satu</option>
                                                    @foreach ($mapel as $item)
                                                        <option value="{{ $item->kode_mapel }}">
                                                            {{ $item->nama_mapel }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <input type="text" id="id_mapel" class="form-control"
                                                    value="{{ $guru->fkMapelGuru->nama_mapel }}" name="id_mapel"
                                                    data-parsley-required="true" readonly />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="deskripsi" class="form-label">Deskripsi </label>
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
                                                placeholder="cth: Allah,Yeses,Yesus. Pisahkan tiap jawaban dengan menggunakan koma (,)"
                                                data-parsley-required="true"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="lampiran" class="form-label">Lampiran (Hanya Boleh PDF)</label>
                                            <input type="file" class="image-preview-filepond" name="lampiran"
                                                id="edit_lampiran" data-max-file-size="5MB"
                                                data-parsley-required="true" />
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
                                <button type="submit" class="btn btn-primary ms-1" id="submit-edit">
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
                                Yakin untuk menghapus materi mata pelajaran
                                <strong class="badge border-danger border-1 text-danger" id="del_mapel"></strong>?
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
            updateForm.find('#deskripsi').val(updateButton.attr('data-bs-deskripsi'));
            updateForm.find('#edit_id_mapel').val(updateButton.attr('data-bs-mapel')).attr(
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
            delForm.find('#del_mapel').text('"' + delButton.attr('data-bs-mapel') + '"')
        })
    </script>

    <script>
        const inputElements = document.querySelectorAll('.image-preview-filepond');
        // const sbmtBtn = document.querySelectorAll('#submit-button');

        Array.from(inputElements).forEach(inputElement => {
            const pond = FilePond.create(inputElement, {
                allowMultiple: false,
                credits: null,
                allowImagePreview: true,
                allowImageFilter: false,
                allowImageExifOrientation: false,
                allowImageCrop: false,
                acceptedFileTypes: ["application/pdf"],
                fileValidateTypeDetectType: (source, type) =>
                    new Promise((resolve, reject) => {
                        // Do custom type detection here and return with promise
                        resolve(type)
                    }),
                onaddfilestart: (file) => {
                    $("#submit-button").attr("disabled", 'disabled');
                    $("#submit-edit").attr("disabled", 'disabled');
                },
                onprocessfiles: () => {
                    $('#submit-button').removeAttr('disabled');
                    $('#submit-edit').removeAttr('disabled');
                },
                onremovefile: (error, file) => {
                    $('#submit-button').removeAttr('disabled');
                    $('#submit-edit').removeAttr('disabled');
                },
                onprocessfileabort: (file) => {
                    $('#submit-button').removeAttr('disabled');
                    $('#submit-edit').removeAttr('disabled');
                }
            })
            FilePond.setOptions({
                server: {
                    process: '/tmp-upload-materi',
                    revert: '/tmp-delete-materi',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }
            })

        });
    </script>
@endsection
