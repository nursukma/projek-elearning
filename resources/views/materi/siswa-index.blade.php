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
                    <h3>Materi</h3>
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }} </td>
                                    <td>
                                        <a class="text-info fw-bold" href="#detailModal" data-bs-toggle="modal"
                                            data-bs-target="#detailModal" data-bs-deskripsi="{{ $item->deskripsi }}"
                                            data-bs-mapel="{{ $item->fkMapelMateri->nama_mapel }}"
                                            data-bs-berkas="{{ $item->berkas }}">
                                            {{ $item->fkMapelMateri->nama_mapel }}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- DETAIL MODAL --}}
            <div class="modal fade text-left" id="detailModal" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel33" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="modal-title">
                                Materi
                            </h4>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <form class="form" id="detail-form" enctype="multipart/form-data" data-parsley-validate>
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="mapel" class="form-label">Mata Pelajaran</label>
                                            <input type="text" id="id_mapel" class="form-control" name="id_mapel"
                                                data-parsley-required="true" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="deskripsi" class="form-label">Deskripsi </label>
                                            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" data-parsley-required="true" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="lampiran" class="form-label">Berkas</label>
                                            <a class="sidebar-link" title="Unduh" id="berkas">
                                                <i class="bi bi-file-earmark-pdf-fill"></i>Unduh
                                            </a>
                                        </div>
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
        $('#detailModal').bind('show.bs.modal', event => {
            const updateForm = $('form#detail-form');
            const updateButton = $(event.relatedTarget);

            var linkDownload = updateButton.attr('data-bs-berkas');
            const btnDownload = updateForm.find('#berkas');
            var encodedFile = encodeURIComponent(linkDownload);

            // updateForm.attr('action', updateButton.attr('data-bs-act'));
            updateForm.find('#deskripsi').val(updateButton.attr('data-bs-deskripsi'));
            updateForm.find('#id_mapel').val(updateButton.attr('data-bs-mapel'));

            // Split the filepath into folder and filename
            var parts = linkDownload.split('/');
            var folder = parts[0];
            var filename = parts[1];

            // Prepare the URL for the download route
            var url = "{{ route('materi-siswa.download', ['folder' => ':folder', 'filename' => ':filename']) }}"
                .replace(':folder', folder)
                .replace(':filename', filename);

            btnDownload.click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'GET',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
            })
        }).bind('hide.bs.modal', e => {

        });
    </script>
@endsection
