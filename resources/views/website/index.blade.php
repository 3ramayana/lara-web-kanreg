<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>@yield('meta_title', 'Kantor Regional XIV BKN')</title>
    <meta name="description" content="@yield('meta_description', 'Website Resmi Kantor Regional XIV Badan Kepegawaian Negara')">
    <meta name="keywords" content="@yield('meta_keywords', 'BKN, Kanreg XIV, Kepegawaian, ASN, CPNS, PPPK')">
    
    <!-- Open Graph / Social Media Meta Tags -->
    <meta property="og:title" content="@yield('meta_title', 'Kantor Regional XIV BKN')">
    <meta property="og:description" content="@yield('meta_description', 'Website Resmi Kantor Regional XIV Badan Kepegawaian Negara')">
    <meta property="og:image" content="@yield('meta_image', asset('bkn/logo_bkn.png'))">
    <meta property="og:type" content="@yield('meta_type', 'website')">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('meta_title', 'Kantor Regional XIV BKN')">
    <meta name="twitter:description" content="@yield('meta_description', 'Website Resmi Kantor Regional XIV Badan Kepegawaian Negara')">
    <meta name="twitter:image" content="@yield('meta_image', asset('bkn/logo_bkn.png'))">

    <!-- Favicons -->
    <link href="{{ asset('bkn/logo_bkn.png') }}" rel="icon">
    <link href="{{ asset('bkn/logo_bkn.png') }}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Marcellus:wght@400&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets1/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets1/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets1/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('assets1/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets1/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('assets1/css/main.css') }}" rel="stylesheet">

    <!-- =======================================================
  * Template Name: AgriCulture
  * Template URL: https://bootstrapmade.com/agriculture-bootstrap-website-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    @include('website.components._header')

    <main class="main">

        @yield('content')

    </main>

    @include('website.components._footer')

    <!-- Kumpulan Tombol Mengambang (Kanan Bawah) -->
    <div class="floating-action-group">
        <style>
            .floating-action-group {
                position: fixed;
                bottom: 30px; /* Dirapatkan ke bawah */
                right: 20px;
                z-index: 9998;
                display: flex;
                flex-direction: column-reverse; /* Tumpuk dari bawah ke atas */
                gap: 10px; /* Dikurangi agar lebih rapat */
                align-items: center;
            }
            /* Override posisi anak-anaknya agar diatur oleh flexbox */
            .floating-action-group .float-wa,
            .floating-action-group .scroll-top,
            .floating-action-group .a11y-widget,
            .floating-action-group #kopace-widget,
            .floating-action-group .share-btn {
                position: relative !important;
                bottom: auto !important;
                right: auto !important;
                left: auto !important;
            }
            /* Menyeragamkan & mengecilkan ukuran semua tombol float */
            .floating-action-group .float-wa,
            .floating-action-group .scroll-top,
            .floating-action-group .a11y-btn,
            .floating-action-group #kopace-btn,
            .floating-action-group .share-btn {
                width: 45px !important;
                height: 45px !important;
                font-size: 20px !important;
                line-height: 45px !important;
                display: flex !important;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                cursor: pointer; 
                transition: 0.3s;
                box-shadow: 0 4px 10px rgba(0,0,0,0.3);
                text-decoration: none;
            }
            .share-btn { background-color: #ffc107; color: #000; }
            .share-btn:hover { background-color: #e0a800; transform: scale(1.1); color: #000; }

            .a11y-widget { z-index: 9999; }
            .a11y-btn {
                background-color: #2e8b57; color: white; border-radius: 50%;
                box-shadow: 0 4px 10px rgba(0,0,0,0.3);
                cursor: pointer; transition: 0.3s;
            }
            .a11y-btn:hover { background-color: #246d44; }
            .a11y-menu {
                display: none; position: absolute; bottom: 60px; right: 0; left: auto; background: white;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2); border-radius: 10px; padding: 10px; width: 220px;
        }
        .a11y-menu.active { display: block; }
        .a11y-menu button {
            width: 100%; padding: 8px 10px; margin-bottom: 5px; border: none; background: #f8f9fa;
            border-radius: 5px; text-align: left; font-weight: 500; font-size: 14px; transition: 0.2s; color: #333;
        }
        .a11y-menu button:hover { background: #e9ecef; }
        .a11y-menu button i { margin-right: 8px; width: 20px; text-align: center; }
        
        body.a11y-high-contrast { background-color: #000 !important; color: #fff !important; }
        body.a11y-high-contrast * { background-color: #000 !important; color: #fff !important; border-color: #fff !important; }
        body.a11y-grayscale { filter: grayscale(100%) !important; }
    </style>

    <div class="a11y-widget">
        <div class="a11y-menu" id="a11yMenu">
            <button onclick="a11yToggleContrast()"><i class="bi bi-circle-half"></i> Kontras Tinggi</button>
            <button onclick="a11yToggleGrayscale()"><i class="bi bi-droplet-half"></i> Skala Abu-abu</button>
            <button onclick="a11yChangeFontSize(1)"><i class="bi bi-zoom-in"></i> Perbesar Teks</button>
            <button onclick="a11yChangeFontSize(-1)"><i class="bi bi-zoom-out"></i> Perkecil Teks</button>
            <button onclick="a11yReset()"><i class="bi bi-arrow-counterclockwise"></i> Reset Pengaturan</button>
        </div>
        <div class="a11y-btn" onclick="document.getElementById('a11yMenu').classList.toggle('active')" title="Aksesibilitas Disabilitas">
            <i class="bi bi-universal-access"></i>
        </div>
    </div>

    <script>
        let currentFontSize = 100;
        function a11yToggleContrast() { document.body.classList.toggle('a11y-high-contrast'); }
        function a11yToggleGrayscale() { document.body.classList.toggle('a11y-grayscale'); }
        function a11yChangeFontSize(step) {
            currentFontSize += (step * 10);
            document.body.style.fontSize = currentFontSize + '%';
        }
        function a11yReset() {
            document.body.classList.remove('a11y-high-contrast', 'a11y-grayscale');
            currentFontSize = 100;
            document.body.style.fontSize = '100%';
        }
    </script>
    <!-- End Accessibility Widget -->

    <!-- Smart Chatbot Kopace BKN -->
    @include('website.components.chatbot')

    <!-- Share Button -->
    <a href="javascript:void(0)" class="share-btn" onclick="shareWebsite()" title="Bagikan Halaman Ini">
        <i class="bi bi-share-fill"></i>
    </a>

    <!-- Whatsapp CTA -->
    <a href="http://wa.me/+6282138868989" class="float-wa d-flex align-items-center justify-content-center"
        target="_blank">
        <i class="bi bi-whatsapp my-float"></i>
    </a>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>
    </div> <!-- Penutup floating-action-group -->

    <script>
        function shareWebsite() {
            if (navigator.share) {
                navigator.share({
                    title: document.title,
                    text: 'Lihat informasi terbaru di Website Resmi Kantor Regional XIV BKN',
                    url: window.location.href,
                }).catch(console.error);
            } else {
                // Fallback jika browser tidak mendukung Web Share API
                const dummy = document.createElement('input');
                document.body.appendChild(dummy);
                dummy.value = window.location.href;
                dummy.select();
                document.execCommand('copy');
                document.body.removeChild(dummy);
                alert('Tautan halaman berhasil disalin ke papan klip (clipboard)! Silakan tempel untuk membagikan.');
            }
        }
    </script>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets1/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets1/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ asset('assets1/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('assets1/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('assets1/vendor/glightbox/js/glightbox.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('assets1/js/main.js') }}"></script>

</body>

</html>
