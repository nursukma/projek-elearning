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
                    <h3>Data User</h3>
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
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Tipe</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }} </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->username }}</td>
                                    <td>{{ $item->role }}</td>
                                    <td>

                                        <form action="{{ route('user.ban', $item->id) }}" method="post">
                                            @method('put')
                                            @csrf
                                            @if ($item->stts == 1)
                                                <div class="form-check form-check-success form-switch">
                                                    <input class="form-check-input" type="checkbox" id="status"
                                                        name="status" title='Aktif' checked onclick="submit()">
                                                </div>
                                            @else
                                                <div class="form-check form-check-danger form-switch">
                                                    <input class="form-check-input" type="checkbox" id="status"
                                                        name="status" title="Nonaktif" onclick="submit()">
                                                </div>
                                            @endif
                                        </form>
                                    </td>
                                    <td>
                                        <button type="button" class="btn icon btn-info rounded-pill" data-bs-toggle="modal"
                                            data-bs-target="#editModal" title="Ubah Data" id="edit"
                                            data-bs-toggle="modal" data-bs-target="#editModal"
                                            data-bs-act="{{ route('user.update', $item->id) }}"
                                            data-bs-username="{{ $item->username }}"
                                            data-bs-password="{{ $item->password }}">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        <button type="button" class="btn icon btn-danger rounded-pill" title="Hapus Data"
                                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                                            data-bs-act="{{ route('user.destroy', $item->id) }}"
                                            data-bs-nama_user="{{ $item->name }}" data-bs-role="{{ $item->role }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" id="username" class="form-control"
                                                placeholder="cth: 12 TKR" name="username" data-parsley-required="true" />
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="text" id="password" class="form-control"
                                                placeholder="cth: password" name="password" />
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
                                Yakin untuk menghapus data user
                                <strong class="badge border-danger border-1 text-danger" id="del_nama_user"> </strong>
                                <p>dengan tipe user <strong class="badge border-danger border-1 text-danger"
                                        id="del_role_user"> </strong>?</p>
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
            updateForm.find('#username').val(updateButton.attr('data-bs-username'));
            // updateForm.find('#password').val(updateButton.attr('data-bs-password'));
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
            delForm.find('#del_nama_user').text('"' + delButton.attr('data-bs-nama_user') + '"')
            delForm.find('#del_role_user').text('"' + delButton.attr('data-bs-role') + '"')
        })
    </script>
    <script>
        $(function() {
            $('#status').click(function() {
                var active = $(this).prop('checked') == true ? 1 : 0;
                $('#status').val(active);
            });
        });
    </script>
@endsection
