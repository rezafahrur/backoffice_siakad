@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
        <div>
            <h4 class="mb-3 mb-md-0">👋 Selamat Datang, {{ Session::get('nama_lengkap') }}</h4>
        </div>
        <div class="d-flex align-items-center flex-wrap text-nowrap">
            <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="calendar"></i>
                {{ $semester_aktif->nama_semester ?? 'Semester not set' }}
            </button>

            <button type="button" class="btn btn-outline-primary btn-icon-text me-2 mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="printer"></i>
                Cetak
            </button>

            <button type="button" class="btn btn-primary btn-icon-text mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="download-cloud"></i>
                Unduh Laporan
            </button>

            <a href="https://lms.poltekbatu.ac.id/login/interpreterAuthenticatorDARe5.php?u={{ session('lms_credentials.username') }}&p={{ session('lms_credentials.password') }}"
                target="_blank" class="btn btn-primary btn-icon-text ms-2 mb-2 mb-md-0">
                <i class="btn-icon-prepend" data-feather="log-in"></i>
                Connect to LMS Poltekbatu
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-2">Mahasiswa</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $total_mahasiswa }}</h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-secondary">
                                            <span>{{ $bulan_tahun }}</span>
                                        </p>
                                    </div>
                                </div>
                                {{-- <div class="col-6 col-md-12 col-xl-7">
                                    <div id="customersChart" class="mt-md-3 mt-xl-0"></div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-2">Dosen</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $total_dosen }}</h3>
                                    <div class="d-flex align-items-baseline">
                                        <div class="d-flex align-items-baseline">
                                            <p class="text-secondary">
                                                <span>{{ $bulan_tahun }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-6 col-md-12 col-xl-7">
                                    <div id="ordersChart" class="mt-md-3 mt-xl-0"></div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-2">Human Resource</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $total_hr }}</h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-secondary">
                                            <span>{{ $bulan_tahun }}</span>
                                        </p>
                                    </div>
                                </div>
                                {{-- <div class="col-6 col-md-12 col-xl-7">
                                    <div id="growthChart" class="mt-md-3 mt-xl-0"></div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-2">Program Studi</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $total_prodi }}</h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-secondary">
                                            <span>{{ $bulan_tahun }}</span>
                                        </p>
                                    </div>
                                </div>
                                {{-- <div class="col-6 col-md-12 col-xl-7">
                                    <div id="growthChart" class="mt-md-3 mt-xl-0"></div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-xl-12 stretch-card">
            <div class="row flex-grow-1">
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-2">Mata Kuliah</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $total_mata_kuliah }}</h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-secondary">
                                            <span>{{ $bulan_tahun }}</span>
                                        </p>
                                    </div>
                                </div>
                                {{-- <div class="col-6 col-md-12 col-xl-7">
                                    <div id="customersChart" class="mt-md-3 mt-xl-0"></div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-2">Ruang Kelas</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $total_ruang_kelas }}</h3>
                                    <div class="d-flex align-items-baseline">
                                        <div class="d-flex align-items-baseline">
                                            <p class="text-secondary">
                                                <span>{{ $bulan_tahun }}</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-6 col-md-12 col-xl-7">
                                    <div id="ordersChart" class="mt-md-3 mt-xl-0"></div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-2">Kelas</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $total_kelas }}</h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-secondary">
                                            <span>{{ $bulan_tahun }}</span>
                                        </p>
                                    </div>
                                </div>
                                {{-- <div class="col-6 col-md-12 col-xl-7">
                                    <div id="growthChart" class="mt-md-3 mt-xl-0"></div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <h6 class="card-title mb-2">Kurikulum</h6>
                            </div>
                            <div class="row">
                                <div class="col-6 col-md-12 col-xl-5">
                                    <h3 class="mb-2">{{ $total_kurikulum }}</h3>
                                    <div class="d-flex align-items-baseline">
                                        <p class="text-secondary">
                                            <span>{{ $bulan_tahun }}</span>
                                        </p>
                                    </div>
                                </div>
                                {{-- <div class="col-6 col-md-12 col-xl-7">
                                    <div id="growthChart" class="mt-md-3 mt-xl-0"></div>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- row -->

    <div class="row">
        <div class="col-lg-7 col-xl-8 grid-margin stretch-card mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-baseline mb-2">
                        <h6 class="card-title mb-0">Jumlah Target Mahasiswa Baru</h6>
                        <div class="dropdown mb-2">
                            <button class="btn p-0" type="button" id="dropdownMenuButton4" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="icon-lg text-muted pb-3px" data-feather="more-horizontal"></i>
                            </button>
                        </div>
                    </div>
                    <div id="periodePerkuliahanChart"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-xl-4 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title mb-0">Status Mahasiswa</h6>
                    <div id="storageCharts"></div>
                    {{-- <div class="row mb-3">
                        <div class="col-6 d-flex justify-content-end">
                            <div>
                                <label
                                    class="d-flex align-items-center justify-content-end tx-10 text-uppercase fw-bolder">Mahasiswa
                                    Aktif
                                    <span class="p-1 ms-1 rounded-circle bg-success"></span></label>
                                <h5 class="fw-bolder mb-0 text-end" id="mahasiswaAktifCount">0</h5>
                            </div>
                        </div>
                        <div class="col-6">
                            <div>
                                <label class="d-flex align-items-center tx-10 text-uppercase fw-bolder"><span
                                        class="p-1 me-1 rounded-circle bg-danger"></span> Mahasiswa Non-Aktif</label>
                                <h5 class="fw-bolder mb-0" id="mahasiswaNonAktifCount">0</h5>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <!-- row -->

        <!-- Modal untuk edit semester -->
        {{-- <div class="modal fade" id="editSemesterModal" tabindex="-1" aria-labelledby="editSemesterModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editSemesterModalLabel">Edit Semester</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('tahun-akademik.update', $tahunAkademik->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="semester_id" class="form-label">Semester</label>
                            <select class="form-select" id="semester_id" name="semester_id">
                                @foreach ($semesters as $semester)
                                    <option value="{{ $semester->id }}"
                                        {{ $tahunAkademik->semester_id == $semester->id ? 'selected' : '' }}>
                                        {{ $semester->nama_semester }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div> --}}
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/dashboard/mahasiswa/status')
                .then(response => response.json())
                .then(data => {
                    var options = {
                        chart: {
                            type: 'donut',
                        },
                        series: [data.aktif, data.non_aktif],
                        labels: ['Mahasiswa Aktif', 'Mahasiswa Non-Aktif'],
                        colors: ['#4caf50', '#f44336'],
                        legend: {
                            position: 'bottom',
                        },
                        dataLabels: {
                            enabled: true,
                        },
                    };

                    var chart = new ApexCharts(document.querySelector("#storageCharts"), options);
                    chart.render();

                    document.getElementById('mahasiswaAktifCount').innerText = data.aktif;
                    document.getElementById('mahasiswaNonAktifCount').innerText = data.non_aktif;
                })
                .catch(error => console.error('Error:', error));
        });

        document.addEventListener('DOMContentLoaded', function() {
            fetch('/periode-perkuliahan/chart-data')
                .then(response => response.json())
                .then(data => {
                    const categories = data.map(item => item.program_studi);
                    const seriesData = data.map(item => item.jml_target_mhs_baru);
                    const tooltipData = data.map(item => `${item.semester} - ${item.program_studi}`);

                    var options = {
                        chart: {
                            type: 'bar',
                            height: 350
                        },
                        series: [{
                            name: 'Jumlah Target Mahasiswa Baru',
                            data: seriesData
                        }],
                        xaxis: {
                            categories: categories
                        },
                        tooltip: {
                            y: {
                                formatter: function(value, {
                                    dataPointIndex
                                }) {
                                    return tooltipData[dataPointIndex] + ': ' + value;
                                }
                            }
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#periodePerkuliahanChart"), options);
                    chart.render();
                });
        });
    </script>
@endpush
