@extends('website.layout-detail')

@section('detail-content')

@section('title-detail')
    Pusat Konsultasi Pensiun
@endsection

@section('desc-detail')
    Temukan jawaban atas permasalahan pensiun yang umum terjadi, atau sampaikan pertanyaan Anda langsung kepada kami.
@endsection

<section id="search-section" class="search-section section mt-4 pb-0">
    <div class="container" data-aos="fade-up">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h2>Cari Solusi Kendala Pensiun Anda</h2>
                <p>Ketikkan permasalahan yang Anda alami terkait layanan pensiun, dan sistem kami akan merekomendasikan solusinya seketika.</p>
                <form action="" method="GET" class="mt-4">
                    <div class="input-group input-group-lg shadow-sm position-relative" style="border-radius: 10px; overflow:visible;">
                        <input type="text" name="q" id="searchKeyword" value="{{ $query }}" class="form-control border-0" placeholder="Contoh: Mengapa SK BUP saya belum turun padahal sudah bulan ini..." required style="padding: 20px; border-top-left-radius: 10px; border-bottom-left-radius: 10px;" autocomplete="off">
                        <button class="btn btn-primary" type="submit" style="padding: 0 30px; background-color: var(--accent-color); border-color: var(--accent-color); border-top-right-radius: 10px; border-bottom-right-radius: 10px;">
                            <i class="bi bi-search"></i> Cari Rekomendasi
                        </button>
                        
                        <!-- Suggestions Box -->
                        <div id="suggestionsBox" class="position-absolute w-100 bg-white border rounded shadow d-none text-start" style="z-index: 1050; top: 100%; left: 0; max-height: 250px; overflow-y: auto; margin-top: 5px;">
                            <ul class="list-group list-group-flush mb-0" id="suggestionsList">
                                <!-- Suggestions will be populated here -->
                            </ul>
                        </div>
                    </div>
                </form>

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const searchInput = document.getElementById('searchKeyword');
                        const suggestionsBox = document.getElementById('suggestionsBox');
                        const suggestionsList = document.getElementById('suggestionsList');
                        let timeoutId;

                        searchInput.addEventListener('input', function() {
                            clearTimeout(timeoutId);
                            const query = this.value.trim();

                            if (query.length < 3) {
                                suggestionsBox.classList.add('d-none');
                                return;
                            }

                            timeoutId = setTimeout(() => {
                                fetch(`/layanan/konsultasi-pensiun/suggest?q=${encodeURIComponent(query)}`)
                                    .then(response => response.json())
                                    .then(data => {
                                        suggestionsList.innerHTML = '';
                                        if (data.length > 0) {
                                            data.forEach(item => {
                                                const li = document.createElement('li');
                                                li.className = 'list-group-item list-group-item-action text-dark';
                                                li.style.cursor = 'pointer';
                                                li.innerHTML = `<i class="bi bi-search me-2 text-muted"></i> ${item}`;
                                                li.addEventListener('click', function() {
                                                    searchInput.value = item;
                                                    suggestionsBox.classList.add('d-none');
                                                    searchInput.closest('form').submit();
                                                });
                                                suggestionsList.appendChild(li);
                                            });
                                            suggestionsBox.classList.remove('d-none');
                                        } else {
                                            suggestionsBox.classList.add('d-none');
                                        }
                                    });
                            }, 300);
                        });

                        document.addEventListener('click', function(e) {
                            if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
                                suggestionsBox.classList.add('d-none');
                            }
                        });
                    });
                </script>

                @if(count($popularTags) > 0)
                <div class="mt-4">
                    <span class="text-muted small me-2">Pencarian Populer:</span>
                    @foreach($popularTags as $tag)
                        <a href="?q={{ urlencode($tag) }}" class="badge bg-light text-dark border border-secondary text-decoration-none me-1 mb-2 px-3 py-2 btn-tag-hover">
                            #{{ $tag }}
                        </a>
                    @endforeach
                </div>
                <style>
                    .btn-tag-hover:hover {
                        background-color: var(--accent-color) !important;
                        color: white !important;
                        border-color: var(--accent-color) !important;
                    }
                </style>
                @endif

            </div>
        </div>
    </div>
</section>

<section id="faq" class="faq section mt-2 pt-5">
    <div class="container" data-aos="fade-up" data-aos-delay="200">
        
        @if($hasSearched)
            <div class="row mb-4">
                <div class="col-12 text-center">
                    <h4>Hasil Rekomendasi untuk: <span class="text-primary">"{{ $query }}"</span></h4>
                </div>
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-10">
                @if($cases->count() > 0)
                    <div class="faq-container">
                        @foreach ($cases as $item)
                            <div class="faq-item {{ $loop->first && $hasSearched ? 'faq-active' : '' }}">
                                <h3>
                                    <span class="num"><i class="bi bi-lightbulb text-warning"></i></span> 
                                    <span>
                                        {{$item->title}}
                                        @if(isset($item->similarity_score) && $item->similarity_score > 0)
                                            <span class="badge bg-success ms-2" style="font-size: 0.6em; vertical-align: middle;" title="Tingkat Kemiripan">
                                                <i class="bi bi-bullseye"></i> Kecocokan: {{ number_format($item->similarity_score * 100, 1) }}%
                                            </span>
                                        @endif
                                    </span>
                                </h3>
                                <div class="faq-content">
                                    <div class="overflow-hidden">
                                        <div class="mb-3 mt-3">
                                            <strong><i class="bi bi-exclamation-triangle text-danger"></i> Kendala yang Relevan:</strong>
                                            <div class="mt-2 text-muted">{!! clean($item->problem) !!}</div>
                                        </div>
                                        @if(!empty($item->resolution))
                                        <div class="p-3 bg-light border-start border-4 border-success rounded">
                                            <strong><i class="bi bi-check-circle-fill text-success"></i> Rekomendasi Penyelesaian:</strong>
                                            <div class="mt-2">{!! clean($item->resolution) !!}</div>
                                        </div>
                                        @endif
                                        
                                        @if(!empty($item->tags))
                                        <div class="mt-3 mb-2">
                                            @foreach($item->tags as $tag)
                                                <span class="badge bg-secondary rounded-pill fw-normal px-3">{{ $tag }}</span>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <i class="faq-toggle bi bi-chevron-right"></i>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $cases->links() }}
                    </div>
                @else
                    <div class="text-center p-5 bg-white shadow-sm rounded border">
                        <img src="{{ asset('assets/bkn/faq.png') }}" alt="Not Found" style="width: 150px; opacity: 0.5;" class="mb-3">
                        <h3>Maaf, rekomendasi untuk kendala Anda belum tersedia.</h3>
                        <p class="text-muted mb-4">Sistem kami belum menemukan solusi yang cocok dengan pencarian Anda di dalam basis pengetahuan.</p>
                        
                        <div class="alert alert-info d-inline-block text-start mb-4">
                            <strong><i class="bi bi-info-circle"></i> Saran:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Gunakan kata kunci yang lebih singkat dan spesifik.</li>
                                <li>Periksa ejaan kata.</li>
                            </ul>
                        </div>
                        <br>
                        
                        <a href="https://support-siasn.bkn.go.id/" target="_blank" class="btn btn-primary btn-lg" style="background-color: var(--accent-color); border-color: var(--accent-color); border-radius: 50px; padding: 12px 30px;">
                            <i class="bi bi-headset"></i> Hubungi Helpdesk SIASN BKN
                        </a>
                        <p class="mt-3 text-muted small">Anda akan diarahkan ke portal resmi layanan pengaduan SIASN.</p>
                    </div>
                @endif
            </div>
        </div>
        
        @if(!$hasSearched && $cases->count() > 0)
            <div class="text-center mt-5">
                <p class="text-muted">Gunakan kotak pencarian di atas untuk menemukan solusi masalah pensiun spesifik Anda.</p>
            </div>
        @endif
        
    </div>
</section>

@endsection
