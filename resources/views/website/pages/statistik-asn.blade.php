@extends('website.page')

@section('title-detail', 'Visualisasi Data Statistik ASN')

@section('desc-detail', 'Mewujudkan Satu Data ASN untuk Wilayah Kerja Kantor Regional XIV BKN Manokwari')

@section('detail-content')
<link rel="stylesheet" href="{{ asset('assets1/css/leaflet.css') }}" />
<style>
    #asnMap { height: 400px; border-radius: 10px; z-index: 1; }
    .leaflet-popup-content-wrapper { border-radius: 10px; }
    .leaflet-popup-content { font-family: inherit; font-size: 14px; text-align: center; }
</style>

<div class="row my-5">
    <div class="col-lg-12">
        <h2 class="mb-2 text-center">Infografis Kepegawaian Tahun {{ $selectedYear }}</h2>
        <p class="text-center text-muted mb-4">
            Menampilkan data untuk: 
            <strong>{{ $chartData['label1'] }}</strong>
            @if($isCompare)
            <br>
            <span class="text-danger fw-bold">VS</span> 
            <br>
            <strong>{{ $chartData['label2'] }}</strong>
            @endif
        </p>

        <!-- Filter Form -->
        <div class="card shadow-sm border-0 mb-5 bg-light">
            <div class="card-body">
                <form method="GET" action="{{ url('/statistik-asn') }}">
                    <div class="row g-3 align-items-end justify-content-center mb-3">
                        <div class="col-md-2">
                            <label for="year" class="form-label fw-bold">Tahun Utama</label>
                            <select name="year" id="year" class="form-select">
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="month" class="form-label fw-bold">Bulan Utama</label>
                            <select name="month" id="month" class="form-select">
                                @foreach($monthsList as $num => $name)
                                    <option value="{{ $num }}" {{ $selectedMonth == $num ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="city_id" class="form-label fw-bold">Wilayah Utama</label>
                            <select name="city_id" id="city_id" class="form-select">
                                <option value="all" {{ $selectedCity === 'all' ? 'selected' : '' }}>Semua Wilayah Kerja</option>
                                @foreach($availableCities as $city)
                                    <option value="{{ $city->id }}" {{ $selectedCity == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check mt-4">
                                <input class="form-check-input" type="checkbox" name="compare" id="compareData" value="1" {{ $isCompare ? 'checked' : '' }} onchange="document.getElementById('compareSection').style.display = this.checked ? 'flex' : 'none';">
                                <label class="form-check-label fw-bold text-primary" for="compareData">
                                    <i class="bi bi-intersect"></i> Bandingkan Data
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Compare Section -->
                    <div class="row g-3 align-items-end justify-content-center pt-3 border-top" id="compareSection" style="display: {{ $isCompare ? 'flex' : 'none' }};">
                        <div class="col-md-2">
                            <label for="compare_year" class="form-label fw-bold text-danger">Tahun VS</label>
                            <select name="compare_year" id="compare_year" class="form-select">
                                @foreach($availableYears as $year)
                                    <option value="{{ $year }}" {{ $compareYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="compare_month" class="form-label fw-bold text-danger">Bulan VS</label>
                            <select name="compare_month" id="compare_month" class="form-select">
                                @foreach($monthsList as $num => $name)
                                    <option value="{{ $num }}" {{ $compareMonth == $num ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="compare_city_id" class="form-label fw-bold text-danger">Wilayah Pembanding</label>
                            <select name="compare_city_id" id="compare_city_id" class="form-select">
                                <option value="all" {{ $compareCity === 'all' ? 'selected' : '' }}>Semua Wilayah Kerja</option>
                                @foreach($availableCities as $city)
                                    <option value="{{ $city->id }}" {{ $compareCity == $city->id ? 'selected' : '' }}>{{ $city->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3"></div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary px-5 rounded-pill shadow">
                                <i class="bi bi-funnel"></i> Terapkan Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Peta Geografis -->
        <div class="card shadow-sm border-0 mb-5">
            <div class="card-body p-0">
                <div id="asnMap"></div>
            </div>
        </div>
    </div> <!-- Penutup col-lg-12 utama -->
</div> <!-- Penutup row my-5 -->

<!-- TOMBOL CETAK -->
<div class="row mb-3">
    <div class="col-12 text-end">
        <button onclick="downloadPDF()" class="btn btn-danger shadow-sm px-4" id="btnPdf">
            <i class="bi bi-file-pdf"></i> Cetak Laporan (PDF)
        </button>
    </div>
</div>

<div id="printableArea" class="bg-white p-4 rounded shadow-sm">
    <div class="row">
        <!-- Grafik Tren Pertumbuhan -->
        <div class="col-lg-12 mb-5">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                <h5 class="card-title text-center mb-4">Tren Pertumbuhan ASN Tahun {{ $selectedYear }} <br><small class="text-muted">{{ $selectedCity === 'all' ? 'Seluruh Wilayah Kerja' : $availableCities->where('id', $selectedCity)->first()->name ?? '' }}</small></h5>
                <div style="height: 350px;">
                    <canvas id="chartTrend"></canvas>
                </div>
            </div>
        </div>
        </div>
        <!-- Row 1: Komposisi & Demografi -->
        <div class="col-lg-6 mb-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h5 class="card-title text-center fw-bold">Komposisi Pegawai (PNS vs PPPK)</h5>
                <div style="height: 300px; position: relative;">
                    <canvas id="chartEmployee"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h5 class="card-title text-center fw-bold">Rasio Jenis Kelamin ASN</h5>
                <div style="height: 300px; position: relative;">
                    <canvas id="chartGender"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 2: Pendidikan -->
    <div class="col-lg-12 mb-5">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title text-center fw-bold">Tingkat Kualifikasi Pendidikan Terakhir</h5>
                <div style="height: 400px; position: relative;">
                    <canvas id="chartEducation"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 3: Golongan PNS & PPPK -->
    <div class="col-lg-6 mb-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h5 class="card-title text-center fw-bold">Distribusi Golongan PNS</h5>
                <div style="height: 300px; position: relative;">
                    <canvas id="chartGolPns"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h5 class="card-title text-center fw-bold">Distribusi Golongan PPPK</h5>
                <div style="height: 300px; position: relative;">
                    <canvas id="chartGolPppk"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 4: Masa Kerja & Usia -->
    <div class="col-lg-6 mb-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h5 class="card-title text-center fw-bold">Rentang Masa Kerja ASN</h5>
                <div style="height: 300px; position: relative;">
                    <canvas id="chartMasaKerja"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 mb-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h5 class="card-title text-center fw-bold">Piramida Rentang Usia ASN</h5>
                <div style="height: 300px; position: relative;">
                    <canvas id="chartAge"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Row 5: Jabatan -->
    <div class="col-lg-12 mb-5">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body">
                <h5 class="card-title text-center fw-bold">Distribusi Kelompok Jabatan</h5>
                <div style="height: 350px; position: relative;">
                    <canvas id="chartPosition"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="col-lg-12 mb-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <h5 class="card-title mb-0 fw-bold"><i class="bi bi-table"></i> Rincian Rekapitulasi Data</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Wilayah Kerja</th>
                                <th>Periode</th>
                                <th>Jenis Pegawai</th>
                                <th class="text-end">Laki-Laki</th>
                                <th class="text-end">Perempuan</th>
                                <th class="text-end fw-bold">Total Pegawai</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($data as $index => $row)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $row->city->name ?? 'N/A' }}</td>
                                    <td>{{ $monthsList[$row->month] ?? '' }} {{ $row->year }}</td>
                                    <td>
                                        <span class="badge {{ $row->employee_type === 'PNS' ? 'bg-primary' : 'bg-success' }}">
                                            {{ $row->employee_type }}
                                        </span>
                                    </td>
                                    <td class="text-end">{{ number_format($row->gender_male, 0, ',', '.') }}</td>
                                    <td class="text-end">{{ number_format($row->gender_female, 0, ',', '.') }}</td>
                                    <td class="text-end fw-bold text-primary">{{ number_format($row->gender_male + $row->gender_female, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Data tidak ditemukan untuk filter ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div> <!-- Penutup row printableArea -->
</div> <!-- Penutup printableArea -->

<script src="{{ asset('assets1/js/chart.umd.min.js') }}"></script>
<script src="{{ asset('assets1/js/leaflet.js') }}"></script>
<script src="{{ asset('assets1/js/html2pdf.bundle.min.js') }}"></script>
<script>
    function downloadPDF() {
        const btn = document.getElementById('btnPdf');
        const element = document.getElementById('printableArea');
        
        btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyusun PDF...';
        btn.disabled = true;

        const opt = {
            margin:       [10, 10, 10, 10],
            filename:     'Statistik_ASN_{{ $selectedYear }}.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' }
        };

        html2pdf().set(opt).from(element).save().then(() => {
            btn.innerHTML = '<i class="bi bi-file-pdf"></i> Cetak Laporan (PDF)';
            btn.disabled = false;
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        // --- LEAFLET MAP LOGIC ---
        const mapData = @json($mapData);
        console.log("Memuat Map Data:", mapData);

        if (document.getElementById('asnMap')) {
            // Default center of Papua Barat / Papua Barat Daya
            const map = L.map('asnMap').setView([-1.5, 132.5], 6);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // Tentukan radius maksimal dan minimal
            let maxTotal = 1;
            mapData.forEach(d => { if (d.total > maxTotal) maxTotal = d.total; });

            mapData.forEach(city => {
                // Hitung radius berdasarkan total ASN
                const radius = Math.max(8, (city.total / maxTotal) * 25);
                
                const circle = L.circleMarker([city.lat, city.lng], {
                    color: '#dc3545',
                    fillColor: '#dc3545',
                    fillOpacity: 0.6,
                    radius: radius
                }).addTo(map);

                const popupContent = `<strong>${city.name}</strong><br>Total ASN: <strong>${city.total.toLocaleString('id-ID')}</strong><br><small class="text-muted">Klik untuk lihat detail</small>`;
                circle.bindPopup(popupContent);

                // Event Listener saat marker di-hover
                circle.on('mouseover', function (e) {
                    this.openPopup();
                });

                circle.on('mouseout', function (e) {
                    this.closePopup();
                });

                // Event Listener saat marker diklik (filter ke kota tersebut)
                circle.on('click', function(e) {
                    document.getElementById('city_id').value = city.id;
                    document.getElementById('city_id').form.submit();
                });
            });
        }

        // --- CHART.JS LOGIC ---
        if (typeof Chart === 'undefined') {
            const errorMsg = document.createElement('div');
            errorMsg.className = 'alert alert-danger text-center';
            errorMsg.innerHTML = '<strong>Terjadi Kesalahan:</strong> Pustaka grafik (Chart.js) gagal dimuat. Pastikan jaringan Anda tidak memblokir akses ke CDN.';
            document.querySelector('.row.my-5').prepend(errorMsg);
            console.error("Chart.js failed to load from CDN!");
            return;
        }

        const rawData = @json($chartData);
        const trendData = @json($trendData);
        console.log("Memuat Chart Data:", rawData);

        // Chart Tren Pertumbuhan (Line Chart)
        renderChart('chartTrend', {
            type: 'line',
            data: {
                labels: trendData.labels,
                datasets: [
                    {
                        label: 'Total PNS',
                        data: trendData.pns,
                        borderColor: '#0d6efd',
                        backgroundColor: 'rgba(13, 110, 253, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Total PPPK',
                        data: trendData.pppk,
                        borderColor: '#198754',
                        backgroundColor: 'rgba(25, 135, 84, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }
                ]
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false,
                plugins: { legend: { display: true, position: 'bottom' } },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Fungsi pembuat dataset dinamis
        function buildDatasets(dataObj, singleColor, isPie = false) {
            if (rawData.isCompare) {
                // Dalam mode komparasi, selalu kembalikan sebagai bar dataset
                return [
                    {
                        label: rawData.label1,
                        data: dataObj.values1,
                        backgroundColor: singleColor || '#0d6efd',
                        borderRadius: isPie ? 0 : 5
                    },
                    {
                        label: rawData.label2,
                        data: dataObj.values2,
                        backgroundColor: '#dc3545', // Merah untuk pembanding
                        borderRadius: isPie ? 0 : 5
                    }
                ];
            } else {
                return [{
                    label: 'Jumlah',
                    data: dataObj.values1,
                    backgroundColor: singleColor || (isPie ? ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#6f42c1', '#0dcaf0'] : '#0d6efd'),
                    borderRadius: isPie ? 0 : 5
                }];
            }
        }

        // Fungsi pembantu untuk render chart dengan penanganan error
        function renderChart(id, config) {
            const ctx = document.getElementById(id);
            if (!ctx) return;
            try {
                // Aktifkan legend di mode komparasi
                if (rawData.isCompare) {
                    config.options.plugins = config.options.plugins || {};
                    config.options.plugins.legend = { display: true, position: 'bottom' };
                }
                new Chart(ctx, config);
            } catch (e) {
                console.error("Error rendering chart " + id, e);
            }
        }

        const pieType = rawData.isCompare ? 'bar' : 'pie';
        const doughnutType = rawData.isCompare ? 'bar' : 'doughnut';

        // Chart 1: PNS vs PPPK (Pie -> Bar)
        renderChart('chartEmployee', {
            type: pieType,
            data: {
                labels: rawData.employee.labels,
                datasets: buildDatasets(rawData.employee, null, true)
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // Chart 2: Gender (Doughnut -> Bar)
        renderChart('chartGender', {
            type: doughnutType,
            data: {
                labels: rawData.gender.labels,
                datasets: buildDatasets(rawData.gender, null, true)
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // Chart 3: Education (Horizontal Bar)
        renderChart('chartEducation', {
            type: 'bar',
            data: {
                labels: rawData.education.labels,
                datasets: buildDatasets(rawData.education, '#ffc107')
            },
            options: { 
                indexAxis: 'y',
                responsive: true, 
                maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });

        // Chart 4: Golongan PNS (Bar)
        renderChart('chartGolPns', {
            type: 'bar',
            data: {
                labels: rawData.golPns.labels,
                datasets: buildDatasets(rawData.golPns, '#0d6efd')
            },
            options: { 
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });

        // Chart 5: Golongan PPPK (Bar)
        renderChart('chartGolPppk', {
            type: 'bar',
            data: {
                labels: rawData.golPppk.labels,
                datasets: buildDatasets(rawData.golPppk, '#198754')
            },
            options: { 
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });

        // Chart 6: Masa Kerja (Bar)
        renderChart('chartMasaKerja', {
            type: 'bar',
            data: {
                labels: rawData.masaKerja.labels,
                datasets: buildDatasets(rawData.masaKerja, '#0dcaf0')
            },
            options: { 
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });

        // Chart 7: Age (Bar)
        renderChart('chartAge', {
            type: 'bar',
            data: {
                labels: rawData.age.labels,
                datasets: buildDatasets(rawData.age, '#fd7e14')
            },
            options: { 
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });

        // Chart 8: Position (Bar)
        renderChart('chartPosition', {
            type: 'bar',
            data: {
                labels: rawData.position.labels,
                datasets: buildDatasets(rawData.position, '#6f42c1')
            },
            options: { 
                responsive: true, maintainAspectRatio: false,
                plugins: { legend: { display: false } }
            }
        });

    });
</script>
@endsection
