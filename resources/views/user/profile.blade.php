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
                    <h3>Profil Akun</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-xxl-4 col-xl-4 col-md-2 col-sm-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                                <img src="{{ asset('assets/static/images/faces/1.jpg') }}" class="img-preview rounded-pill"
                                    style="width: 120px; height: 150px; object-fit: cover" />
                                <label class="text-primary mt-2">{{ auth()->user()->name }}</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-8 col-xl-8 col-md-4 col-sm-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-header">
                                <h4 class="card-title">Edit Profil</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form form-horizontal" action="{{ route('profile.update') }}" method="post"
                                        id="update-form" data-parsley-validate>
                                        @csrf
                                        @method('put')
                                        <div class="form-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="username" class="form-label">Username</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <input type="text" id="username" class="form-control"
                                                        value="{{ auth()->user()->username }}" name="username"
                                                        data-parsley-required="true" data-parsley-required="true" />
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="password" class="form-label">Password</label>
                                                </div>
                                                <div class="col-md-8 form-group">
                                                    <input type="text" id="password" class="form-control"
                                                        name="password" />
                                                </div>
                                                <div class="col-sm-12 d-flex justify-content-start">
                                                    <button type="submit" class="btn btn-primary me-1 mb-1">
                                                        Submit
                                                    </button>
                                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                                        Reset
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
            updateForm.find('#nip').val(updateButton.attr('data-bs-nip'));
            updateForm.find('#nama_guru').val(updateButton.attr('data-bs-nama_guru'));
            updateForm.find('#tlp_guru').val(updateButton.attr('data-bs-tlp_guru'));
            updateForm.find('#alamat_guru').val(updateButton.attr('data-bs-alamat_guru'));
            if (updateButton.attr('data-bs-jk_guru') === 'Laki-laki') {
                updateForm.find('#lk').val(updateButton.attr('data-bs-jk_guru')).attr(
                    'checked', 'checked');
            } else {
                updateForm.find('#pr').val(updateButton.attr('data-bs-jk_guru')).attr(
                    'checked', 'checked');
            }
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
            delForm.find('#del_nama_guru').text('"' + delButton.attr('data-bs-nama') + '"')
        })
    </script>
@endsection
