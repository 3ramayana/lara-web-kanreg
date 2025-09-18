<?php

use App\Models\City;
use App\Models\Post;
use App\Models\Answer;
use App\Models\Banner;
use App\Models\Document;
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

Route::post('/question', [QuestionController::class, 'store']);
Route::get('/category/{id}', [QuestionController::class, 'allCategory']);
Route::get('/city/{id}', [QuestionController::class, 'allCity']);

Route::get('/', [LandingController::class, 'index']);
Route::get('/detail-post/{slug}', [LandingController::class, 'show']);
Route::get('/announcement', [AnnouncementController::class, 'index']);
Route::get('/all-news', [NewsController::class, 'allNews']);
Route::get('/all-article', [NewsController::class, 'allArticle']);
Route::get('/detail-announcement/{id}', [AnnouncementController::class, 'show']);

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
	$news = Post::dataSide()->get();
	return view('website.pages.struktur', compact('news'));
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
	return view('website.pages.services.nip-nipppk', compact('news'));
});

Route::get('layanan/cltn', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.services.cltn', compact('news'));
});

Route::get('layanan/kenaikan-pangkat', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.services.kp', compact('news'));
});

Route::get('layanan/peninjauan-masa-kerja', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.services.pmk', compact('news'));
});

Route::get('layanan/mutasi', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.services.mutasi', compact('news'));
});

Route::get('layanan/pencantuman-gelar', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.services.pg', compact('news'));
});

Route::get('layanan/pensiun', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.services.pensiun', compact('news'));
});

Route::get('layanan/pensiun-janda-duda', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.services.pensiun-janda-duda', compact('news'));
});

Route::get('layanan/pengaktifan-pns', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.services.pengaktifan-pns', compact('news'));
});

Route::get('layanan/pengangkatan-cpns', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.services.pengangkatan-cpns', compact('news'));
});

Route::get('layanan/peremajaan-data', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.services.peremajaan-data', compact('news'));
});

Route::get('layanan/fasilitasi-seleksi-metode-cat', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.services.cat', compact('news'));
});

Route::get('layanan/manajemen-talenta', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.services.manajemen-talenta', compact('news'));
});

Route::get('layanan/pembinaan-manajemen-asn', function () {
	$news = Post::dataSide()->get();
	return view('website.pages.services.pembinaan-manajemen', compact('news'));
});

Route::get('layanan/statistik-kepegawaian', function () {
	$statistik = Document::with(['categories'])->where('category_id', 5)->where('is_public', 1)->orderBy('created_at', 'desc')->paginate(9);
	return view('website.pages.services.statistik', compact("statistik"));
});
