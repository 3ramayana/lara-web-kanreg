@extends('website.layout-detail')

@section('meta_title', 'Hasil Pencarian - Kantor Regional XIV BKN')

@section('title-detail')
    Hasil Pencarian
@endsection

@section('desc-detail')
    Menampilkan hasil pencarian untuk: "<b>{{ $q }}</b>"
@endsection

@section('detail-content')
<section id="blog" class="blog section">
    <div class="container">
        
        @if(empty($q))
            <div class="alert alert-info">Silakan masukkan kata kunci pencarian.</div>
        @elseif($posts->isEmpty() && $announcements->isEmpty() && $services->isEmpty())
            <div class="alert alert-warning">Tidak ada hasil yang ditemukan untuk "<b>{{ $q }}</b>"</div>
        @else
            
            {{-- Berita --}}
            @if($posts->isNotEmpty())
                <h4 class="mb-4"><i class="bi bi-newspaper me-2"></i> Berita Kepegawaian</h4>
                <div class="row gy-4 mb-5">
                    @foreach ($posts as $post)
                        <div class="col-12">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="/detail-post/{{ $post->slug }}">{{ $post->title }}</a>
                                    </h5>
                                    <p class="card-text text-muted small">
                                        <i class="bi bi-calendar"></i> {{ $post->created_at->locale('id')->translatedFormat('d F Y') }}
                                    </p>
                                    <p class="card-text">
                                        {{ Str::limit(strip_tags($post->content), 120) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Pengumuman --}}
            @if($announcements->isNotEmpty())
                <h4 class="mb-4"><i class="bi bi-megaphone me-2"></i> Pengumuman</h4>
                <div class="row gy-4 mb-5">
                    @foreach ($announcements as $announcement)
                        <div class="col-12">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="/detail-announcement/{{ encrypt($announcement->id) }}">{{ $announcement->title }}</a>
                                    </h5>
                                    <p class="card-text text-muted small">
                                        <i class="bi bi-calendar"></i> {{ $announcement->created_at->locale('id')->translatedFormat('d F Y') }}
                                    </p>
                                    <p class="card-text">
                                        {{ Str::limit(strip_tags($announcement->content), 120) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Layanan --}}
            @if($services->isNotEmpty())
                <h4 class="mb-4"><i class="bi bi-briefcase me-2"></i> Layanan BKN</h4>
                <div class="row gy-4 mb-5">
                    @foreach ($services as $service)
                        <div class="col-12">
                            <div class="card border-0 shadow-sm mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        {{ $service->title }}
                                        <span class="badge bg-primary ms-2">{{ ucfirst($service->category) }}</span>
                                    </h5>
                                    <p class="card-text text-muted small">
                                        Periode: {{ $service->periode }}
                                    </p>
                                    <p class="card-text">
                                        {{ Str::limit(strip_tags($service->description), 120) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        @endif
        
    </div>
</section>
@endsection
