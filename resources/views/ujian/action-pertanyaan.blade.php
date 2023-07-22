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
                        <h3>Form Tambah Pertanyaan</h3>
                    @else
                        <h3>Form Edit Pertanyaan</h3>
                    @endif
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" method="post" action="{{ route('detail-ujian.store') }}"
                            {{-- action="{{ $action == 'add' ? route('detail-ujian.store') : route('detail-ujian.update', $ujian->id) }}" --}} id="update-form" data-parsley-validate enctype="multipart/form-data">
                            @csrf
                            @if ($action == 'edit')
                                @method('put')
                            @endif
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="id_ujian">Id Ujian</label>
                                            <input type="text" id="id_ujian" class="form-control"
                                                value="{{ $action === 'add' ? $ujian->id_ujian : $ujian->id_ujian }}"
                                                name="id_ujian" readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="nama_ujian">Nama Ujian</label>
                                            <input type="text" id="nama_ujian" class="form-control"
                                                placeholder="cth: UAS" name="nama_ujian" value="{{ $ujian->nama_ujian }}"
                                                readonly />
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="pertanyaan_ujian" class="form-label">Pertanyaan</label>
                                            <textarea class="form-control" id="pertanyaan_ujian" name="pertanyaan_ujian" rows="3"
                                                placeholder="cth: Siapa Tuhanmu?" data-parsley-required="true"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="option_jawaban" class="form-label">Pilihan
                                                Jawaban</label>
                                            <textarea class="form-control" id="option_jawaban" name="option_jawaban" rows="3"
                                                placeholder="cth: Allah,Yeses,Yesus. Pisahkan tiap jawaban dengan menggunakan koma (,)"
                                                data-parsley-required="true"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="jawaban_ujian" class="form-label">Jawaban
                                                Benar</label>
                                            <textarea class="form-control" id="jawaban_ujian" rows="2" name="jawaban_ujian"
                                                placeholder="cth: Allah. Isi dengan jawaban benar, jangan dengan huruf a atau b atau z"
                                                data-parsley-required="true"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="level" class="form-label">Level</label>
                                            <input type="text" onkeypress="return isNumberKey(event);" id="level"
                                                class="form-control" placeholder="cth: 1" name="level"
                                                onwheel="return false;" data-parsley-required="true" />
                                        </div>
                                    </div>
                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="lampiran" class="form-label">Lampiran (file gambar)</label>
                                            <input type="file" class="image-preview-filepond" name="lampiran"
                                                id="lampiran" data-max-file-size="1MB" />
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-start">
                                        <button type="submit" class="btn btn-primary me-1 mb-1" id="submit-button">
                                            Submit
                                        </button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">
                                            Reset
                                        </button>
                                        <a href="{{ route('detail-ujian.index', $ujian->id_ujian) }}"
                                            class="btn btn-light-warning me-1 mb-1">Kembali</a>
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
        function isNumberKey(evt) {
            var charCode = (evt.which) ? evt.which : evt.keyCode
            return !(charCode > 31 && (charCode < 48 || charCode > 57));
        }
    </script>
    <script>
        const pond = FilePond.create(document.querySelector(".image-preview-filepond"), {
            allowMultiple: false,
            credits: null,
            allowImagePreview: true,
            allowImageFilter: false,
            allowImageExifOrientation: false,
            allowImageCrop: false,
            acceptedFileTypes: ["image/png", "image/jpg", "image/jpeg"],
            fileValidateTypeDetectType: (source, type) =>
                new Promise((resolve, reject) => {
                    // Do custom type detection here and return with promise
                    resolve(type)
                }),
            onaddfilestart: (file) => {
                $("#submit-button").attr("disabled", 'disabled');
            },
            onprocessfiles: () => {
                $('#submit-button').removeAttr('disabled');
            },
            onremovefile: (error, file) => {
                $('#submit-button').removeAttr('disabled');
            },
            onprocessfileabort: (file) => {
                $('#submit-button').removeAttr('disabled');
            }
        })
        FilePond.setOptions({
            server: {
                process: '/tmp-upload',
                revert: '/tmp-delete',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            }
        })
    </script>
@endsection
