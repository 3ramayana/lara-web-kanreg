<?php

namespace App\Http\Controllers\Website;

use App\Models\Faq;
use App\Models\Post;
use App\Models\Banner;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class LandingController extends Controller
{
    public function index()
    {
        $banner = \Cache::remember('landing_banner', 1800, function () {
            return Banner::select('file', 'name', 'desc')->where('category', 'banner')->where('is_active', 1)->get();
        });

        $headline = \Cache::remember('landing_headline', 1800, function () {
            return Post::with(['categories'])->orderBy('created_at', 'desc')->where('status', 1)->where('is_headline', 1)->take(1)->get();
        });

        $article = \Cache::remember('landing_article', 1800, function () {
            return Post::with(['categories'])->where('category_id', 2)->where('status', 1)->orderBy('created_at', 'desc')->take(6)->get();
        });

        $news = \Cache::remember('landing_news', 1800, function () {
            return Post::with(['categories'])->where('category_id', 1)->where('status', 1)->orderBy('created_at', 'desc')->take(6)->get();
        });

        $faq = \Cache::remember('landing_faq', 1800, function () {
            return Faq::orderBy('created_at', 'desc')->take(5)->get();
        });

        $announcement = \Cache::remember('landing_announcement', 1800, function () {
            return Announcement::where('is_active', 1)->orderBy('created_at', 'DESC')->take(6)->get();
        });

        // Smart Caching with Fallback, Timeout, and Retry
        $events = \Cache::get('webinar_agendas');

        if ($events === null) {
            try {
                $response = Http::timeout(5)->retry(2, 100)->withHeaders([
                    'X-API-KEY' => config('services.webinar.api_key'),
                ])->get(config('services.webinar.base_url') . '/api/agendas');

                if ($response->successful()) {
                    $json = $response->json();
                    $events = $json['data'] ?? [];
                    // Cache data hanya jika request API sukses
                    \Cache::put('webinar_agendas', $events, 3600);
                } else {
                    // Fallback sementara, tidak di-cache
                    $events = [];
                }
            } catch (\Exception $e) {
                \Log::error("Gagal mengambil API Webinar: " . $e->getMessage());
                $events = []; // Fallback error sementara, tidak di-cache
            }
        }

        return view('website.pages.landing', compact('banner', 'headline', 'article', 'news', 'announcement', 'events', 'faq'));
    }

	public function show($slug)
	{
		$post = Post::where('slug', $slug)->firstOrFail();
		$news = Post::DataSide()->get();

		// return $post->thumbnail;
		return view('website.pages.detail-post', compact('post', 'news'));
	}

	public function sidedata()
	{
		// $news = Post::with(['categories'])->where('category_id', 1)->orderBy('created_at','desc')->take(6)->get();
		$news = Post::DataSide()->get();

		return view('website.layout-detail', compact('news'));
	}

	public function announcement() {}

	// public function functionHeadline()
	// {

	// 	return view('website.pages.landing', compact('headline'));
	// }
}
