<?php

use App\Models\City;
use App\Models\Post;
use App\Models\Answer;
use App\Models\Banner;
use App\Models\Service;
use App\Models\Document;
use App\Models\Employee;
use App\Models\Question;
use GuzzleHttp\Psr7\Request;
use App\Models\AnswerQuestion;
use App\Models\QuestionCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\Website\NewsController;
use App\Http\Controllers\Website\LandingController;
use App\Http\Controllers\Website\AnnouncementController;


// Route::get('/', [QuestionController::class, 'all']);
Route::get('all-question', [QuestionController::class, 'all']);

use App\Http\Controllers\Website\SearchController;
use App\Http\Controllers\Website\SitemapController;

Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/sitemap.xml', [SitemapController::class, 'index']);

Route::post('/question', [QuestionController::class, 'store'])->middleware('throttle:5,1');
Route::get('/category/{id}', [QuestionController::class, 'allCategory'])->whereNumber('id');
Route::get('/city/{id}', [QuestionController::class, 'allCity'])->whereNumber('id');

Route::get('/', [LandingController::class, 'index']);
Route::get('/detail-post/{slug}', [LandingController::class, 'show']);
Route::get('/announcement', [AnnouncementController::class, 'index']);
Route::get('/all-news', [NewsController::class, 'allNews']);
Route::get('/all-article', [NewsController::class, 'allArticle']);
Route::get('/detail-announcement/{id}', [AnnouncementController::class, 'show']);

use App\Http\Controllers\Website\AsnStatisticPublicController;
Route::get('/statistik-asn', [AsnStatisticPublicController::class, 'index']);

Route::get('visi-misi', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.visi', compact('news'));
});

Route::get('sejarah', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.sejarah', compact('news'));
});

Route::get('tusi', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.tusi', compact('news'));
});

Route::get('struktur', function () {
	$struktur = Banner::select('file')->where('category', 'struktur_kanreg')->get();
	$news = Post::dataSide()->get();
	// $employee = Employee::all();
	$kepalaBkn = Employee::category('kepala_bkn')->get();
	$kepalaRegional = Employee::category('kepala_regional')->get();
	$administrator = Employee::category('administrator')->get();
	$pengawas = Employee::category('pengawas')->get();

	return view('website.pages.struktur', compact('news', 'kepalaBkn', 'kepalaRegional', 'pengawas', 'administrator', 'struktur'));
});

Route::get('pimpinan', function () {
	$struktur = Banner::select('file')->where('category', 'struktur_pimpinan')->get();
	$news = Post::dataSide()->get();
	$kepalaBkn = Employee::category('kepala_bkn')->get();
	$jptm = Employee::category('jptm')->get();

	return view('website.pages.pimpinan', compact('news', 'jptm', 'struktur', 'kepalaBkn'));
});

Route::get('akuntabilitas', function () {
	$news = Post::dataSide()->get();
	$akuntabilitas = Document::with(['categories'])->where('category_id', 4)->where('is_public', 1)->orderBy('created_at', 'desc')->paginate(10);
	return view('website.pages.akuntabilitas', compact('news', 'akuntabilitas'));
});

Route::get('mutasi', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.mutasi', compact('news'));
});

Route::get('pensiun', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.pensiun', compact('news'));
});

Route::get('inka', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.inka', compact('news'));
});

Route::get('pdsk', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.pdsk', compact('news'));
});

Route::get('ppid', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.ppid', compact('news'));
});

Route::get('kontak', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.kontak', compact('news'));
});

Route::get('layanan', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.layanan', compact('news'));
});
// Route::get('/', [LandingController::class,'functionHeadline']);

// Menu Layanan Kantor Regional XIV BKN
Route::get('layanan/penetapan-nip-nipppk', function () {
	$news = Post::dataSide()->get();
	$data = Service::orderBy('created_at', 'desc')->where('category', 'nip')->paginate(6);
	return view('website.pages.services.nip-nipppk', compact('news', 'data'));
});

Route::get('layanan/cltn', function () {
	$news = Post::dataSide()->get();
	$data = Service::orderBy('created_at', 'desc')->where('category', 'cltn')->paginate(6);
	return view('website.pages.services.cltn', compact('news', 'data'));
});

Route::get('layanan/kenaikan-pangkat', function () {
	$news = Post::dataSide()->get();
	$data = Service::orderBy('created_at', 'desc')->where('category', 'kp')->paginate(6);
	return view('website.pages.services.kp', compact('news', 'data'));
});

Route::get('layanan/peninjauan-masa-kerja', function () {
	$news = Post::dataSide()->get();
	$data = Service::orderBy('created_at', 'desc')->where('category', 'pmk')->paginate(6);
	return view('website.pages.services.pmk', compact('news', 'data'));
});

Route::get('layanan/mutasi', function () {
	$news = Post::dataSide()->get();
	$data = Service::orderBy('created_at', 'desc')->where('category', 'mutasi')->paginate(6);
	return view('website.pages.services.mutasi', compact('news', 'data'));
});

Route::get('layanan/pencantuman-gelar', function () {
	$news = Post::dataSide()->get();
	$data = Service::orderBy('created_at', 'desc')->where('category', 'pg')->paginate(6);
	return view('website.pages.services.pg', compact('news', 'data'));
});

Route::get('layanan/pensiun', function () {
	$data = Service::orderBy('created_at', 'desc')->where('category', 'pensiun')->paginate(6);
	$news = Post::dataSide()->get();
	return view('website.pages.services.pensiun', compact('news', 'data'));
});

Route::get('layanan/pensiun-janda-duda', function () {
	$news = Post::dataSide()->get();
	$data = Service::orderBy('created_at', 'desc')->where('category', 'janda_duda')->paginate(6);
	return view('website.pages.services.pensiun-janda-duda', compact('news', 'data'));
});

Route::get('/layanan/konsultasi-pensiun', [App\Http\Controllers\Website\PensionConsultationController::class, 'index']);
Route::get('/layanan/konsultasi-pensiun/suggest', [App\Http\Controllers\Website\PensionConsultationController::class, 'suggest']);

Route::get('layanan/pengaktifan-pns', function () {
	$data = Service::orderBy('created_at', 'desc')->where('category', 'pengaktifan')->paginate(6);
	$news = Post::dataSide()->get();
	return view('website.pages.services.pengaktifan-pns', compact('news', 'data'));
});

Route::get('layanan/pengangkatan-cpns', function () {
	$data = Service::orderBy('created_at', 'desc')->where('category', 'pengangkatan')->paginate(6);
	$news = Post::dataSide()->get();
	return view('website.pages.services.pengangkatan-cpns', compact('news', 'data'));
});

Route::get('layanan/peremajaan-data', function () {
	$news = Post::dataSide()->get();
	$data = Service::orderBy('created_at', 'desc')->where('category', 'peremajaan')->paginate(6);
	return view('website.pages.services.peremajaan-data', compact('news', 'data'));
});

Route::get('layanan/fasilitasi-seleksi-metode-cat', function () {
	$news = Post::dataSide()->get();
	$data = Service::orderBy('created_at', 'desc')->where('category', 'cat')->paginate(6);
	return view('website.pages.services.cat', compact('news', 'data'));
});

Route::get('layanan/manajemen-talenta', function () {
	$news = Post::dataSide()->get();
	$data = Service::orderBy('created_at', 'desc')->where('category', 'mt')->paginate(6);
	return view('website.pages.services.manajemen-talenta', compact('news', 'data'));
});

Route::get('layanan/pembinaan-manajemen-asn', function () {
	$news = Post::dataSide()->get();
	$data = Service::orderBy('created_at', 'desc')->where('category', 'pembinaan')->paginate(6);
	return view('website.pages.services.pembinaan-manajemen', compact('news', 'data'));
});

Route::get('layanan/statistik-kepegawaian', function () {
	$news = Post::dataSide()->get();
	$akuntabilitas = Document::with(['categories'])->where('category_id', 5)->where('is_public', 1)->orderBy('created_at', 'desc')->paginate(10);
	return view('website.pages.services.statistik', compact('news', 'akuntabilitas'));
});

Route::get('agenda', function () {
	$agenda = Banner::select('file')->where('category', 'agenda')->get();
	$news = Post::dataSide()->get();

	return view('website.pages.agenda', compact('news','agenda'));
});
