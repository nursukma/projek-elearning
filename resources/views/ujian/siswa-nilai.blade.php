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
                    <h3>Nilai Ujian</h3>
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
                                <th>Nilai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }} </td>
                                    <td>{{ $item->nama_ujian }}</td>
                                    <td>{{ $item->nama_mapel }}</td>
                                    @if ($item->created_at == $item->updated_at || $item->updated_at == null)
                                        <td> Belum Mengerjakan</td>
                                    @else
                                        @if ($item->nilai >= 80 && $item->nilai <= 100)
                                            <td><span class="badge bg-success">{{ $item->nilai }}</td></span>
                                        @elseif ($item->nilai >= 50 && $item->nilai <= 79)
                                            <td><span class="badge bg-warning">{{ $item->nilai }}</td></span>
                                        @else
                                            <td><span class="badge bg-danger">{{ $item->nilai }}</td></span>
                                        @endif
                                    @endif
                                    {{-- <td>
                                        <a href="{{ route('daftar-ujian.create', $item->id_ujian) }}"
                                            class="btn icon icon-left btn-success">
                                            <i data-feather="check-circle">
                                            </i> Kerjakan
                                        </a>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('page-script')
    <script></script>
@endsection
