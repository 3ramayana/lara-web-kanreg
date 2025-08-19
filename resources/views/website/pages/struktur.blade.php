@extends('website.layout-detail')

@section('detail-content')
    
		@section('title-detail')
				Struktur Organisasi
		@endsection

		@section('desc-detail')
				Struktur Organisasi Kantor Regional XIV BKN 
		@endsection

		<section id="blog-details" class="blog-details section">
			<div class="container">
				<div class="row">
					<a href="#" class="me-12 thumbnail">
						<img src="{{asset('bkn/struktur.png')}}" alt="" class="img-fluid">
					</a>
		
					<h2 class="category-title">Kepala Kantor Regional XIV BKN</h2>

				<div class="d-md-flex small-img">
					<img src="{{asset('bkn/diana.jpg')}}" alt="" class="img-fluid" style="min-height: 150px; max-height:150px; min-width:205px;max-width:205px">
					<div>
						<table class="table table-hover">
							<tbody>
								<tr>
									<td>Nama Lengkap</td>
									<td>:</td>
									<td>Hardianawati</td>
								</tr>
								<tr>
									<td>NIP</td>
									<td>:</td>
									<td>1932232323232332</td>
								</tr>
								<tr>
									<td>Pangkat/Golongan Ruang</td>
									<td>:</td>
									<td>IVd/</td>
								</tr>
								<tr>
									<td>Pendidikan Terakhir</td>
									<td>:</td>
									<td>IVd/</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				</div>
			</div>
		</section>
@endsection