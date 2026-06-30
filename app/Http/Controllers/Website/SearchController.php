<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Announcement;
use App\Models\Service;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');

        $posts = collect();
        $announcements = collect();
        $services = collect();

        if ($q) {
            $posts = Post::where('title', 'like', "%{$q}%")
                ->orWhere('content', 'like', "%{$q}%")
                ->where('status', 1)
                ->latest()
                ->limit(50)
                ->get();

            $announcements = Announcement::where('title', 'like', "%{$q}%")
                ->orWhere('content', 'like', "%{$q}%")
                ->where('is_active', 1)
                ->latest()
                ->limit(50)
                ->get();

            $services = Service::where('title', 'like', "%{$q}%")
                ->orWhere('description', 'like', "%{$q}%")
                ->latest()
                ->limit(50)
                ->get();
        }

        return view('website.pages.search', compact('posts', 'announcements', 'services', 'q'));
    }
}
