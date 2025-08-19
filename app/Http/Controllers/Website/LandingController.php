<?php

namespace App\Http\Controllers\Website;

use App\Models\Post;
use App\Models\Banner;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LandingController extends Controller
{
    public function index()
		{
			$banner = Banner::select('file')->get();
			$headline = Post::with(['categories'])->orderBy('created_at','desc')->where('status', 1)->where('is_headline', 1)->take(1)->get();
			$article = Post::with(['categories'])->where('category_id', 2)->where('status', 1)->orderBy('created_at','desc')->take(6)->get();
			$news = Post::with(['categories'])->where('category_id', 1)->where('status', 1)->orderBy('created_at','desc')->take(6)->get();

			$announcement = Announcement::where('is_active', 1)->orderBy('created_at', 'DESC')->take(6)->get();


			return view('website.pages.landing', compact('banner', 'headline', 'article', 'news', 'announcement'));
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

		public function announcement()
		{
			
		}

		// public function functionHeadline()
		// {
			
		// 	return view('website.pages.landing', compact('headline'));
		// }
}
