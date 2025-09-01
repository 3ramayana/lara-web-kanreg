@extends('website.layout-detail')

@section('detail-content')

@section('title-detail')
    Peremajaan Data
@endsection

@section('desc-detail')
    Layanan Pemutakhiran Data PNS
@endsection

<section id="blog-details" class="blog-details section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Peremajaan Data</h3>
                <p style="text-align: justify">
                    Peremajaan Data adalah permutakhiran data PNS terkini melalui media elektronik yang dilakukan oleh
                    pengelola kepegawaian sesuai dengan kewenangan Kantor Regional dan selanjutnya disimpan dalam
                    database PNS.
                </p>

                <h3 class="mt-4">Dasar Hukum</h3>
                <ul class="list-unstyled list-check">
                    <li class="d-flex mb-2 align-items-center">
                        <i class="bi bi-file-earmark-text fs-4 me-2"></i>
                        <span>UU No. 20 Tahun 2023 tentang Aparatur Sipil Negara</span>
                    </li>
                    <li class="d-flex mb-2 align-items-center">
                        <i class="bi bi-file-earmark-text fs-4 me-2"></i>
                        <span>Peraturan BKN No. 14 Tahun 2011 Tentang Pedoman Pengembangan Database PNS</span>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</section>
@endsection
