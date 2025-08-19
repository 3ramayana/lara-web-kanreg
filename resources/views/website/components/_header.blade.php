<header id="header" class="header d-flex align-items-center position-relative">
	<div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

		<a href="/" class="logo d-flex align-items-center">
			<!-- Uncomment the line below if you also wish to use an image logo -->
			<img src="{{asset('bkn/logo_bkn.png')}}" alt="AgriCulture" style="min-height: 90px; max-height:90px; min-width:70px;max-width:70px">
			<h1 class="sitename">Kanreg XIV BKN</h1> 
		</a>

		<nav id="navmenu" class="navmenu">
			<ul>
				<li><a href="/" class="{{ request()->is('/') ? 'active' : '' }}">Beranda</a></li>
				<li class="dropdown"><a href="#"><span>Profil</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
					<ul>
						<li><a href="/visi-misi" class="{{ request()->is('/visi-misi') ? 'active' : '' }}">Visi Misi</a></li>
						<li><a href="/sejarah" class="{{ request()->is('/sejarah') ? 'active' : '' }}">Sejarah</a></li>
						<li><a href="/tusi" class="{{ request()->is('/tusi') ? 'active' : '' }}">Tugas & Fungsi</a></li>
						<li><a href="/struktur" class="{{ request()->is('/struktur') ? 'active' : '' }}">Struktur Organisasi</a></li>
						{{-- <li><a href="#">Maklumat Pelayanan</a></li> --}}
					</ul>
				</li>
				<li class="dropdown"><a href="#"><span>Publikasi</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
					<ul>
						<li><a href="/all-news">Berita Kepegawaian</a></li>
						<li><a href="/all-article">Artikel Kepegawaian</a></li>
						<li><a href="/announcement">Pengumuman</a></li>
						<li><a href="https://jdih.bkn.go.id/" target="_blank">Regulasi</a></li>
						<li><a href="/akuntabilitas">Akuntabilitas Kinerja</a></li>
						<li><a href="#">Agenda Kegiatan</a></li>
					</ul>
				</li>
				<li class="dropdown"><a href="#"><span>Pengaduan</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
					<ul>
						<li><a href="https://support-siasn.bkn.go.id/">Helpdesk SIASN</a></li>
						<li><a href="https://helpdesk-sscasn.bkn.go.id/">Helpdesk SSCASN</a></li>
						<li><a href="https://wbs.bkn.go.id/">WBS BKN</a></li>
						<li><a href="https://www.lapor.go.id/" target="_blank">LAPOR GO</a></li>
					</ul>
				</li>
						<li><a href="/layanan">Layanan</a></li>
				{{-- <li class="dropdown"><a href="#"><span>Layanan</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
					<ul>
						<li><a href="mutasi">Mutasi dan Status Kepegawaian</a></li>
						<li><a href="pensiun">Pengangkatan dan Pensiun</a></li>
						<li><a href="inka">Informasi Kepegawaian</a></li>
						<li><a href="pdsk">Pengembangan dan Supervisi Kepegawaian</a></li>
					</ul>
				</li> --}}
				<li><a href="ppid">PPID BKN</a></li>
				<li><a href="kontak">Kontak Kami</a></li>
			</ul>
			<i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
		</nav>

	</div>
</header>
