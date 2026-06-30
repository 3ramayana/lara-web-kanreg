<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RetirementCase;
use App\Models\City;
use App\Models\QuestionCategory;
use App\Models\Post;

class PensionConsultationController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $hasSearched = $request->has('q');

        if ($hasSearched && !empty(trim($query))) {
            // Semua data yang dipublish untuk di-ranking
            $allCases = RetirementCase::where('is_published', true)->latest()->get();

            // Panggil algoritma CBR (Cosine Similarity)
            $cbrService = new \App\Services\CBRService();
            $scoredCases = $cbrService->retrieveSimilarCases($query, $allCases);

            // Manual Pagination untuk Collection
            $perPage = 10;
            $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
            $items = $scoredCases->slice(($currentPage - 1) * $perPage, $perPage)->all();
            
            $cases = new \Illuminate\Pagination\LengthAwarePaginator(
                $items, $scoredCases->count(), $perPage, $currentPage,
                ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(), 'query' => $request->query()]
            );

            // Analytics: Catat jika hasil pencarian kosong
            if ($scoredCases->isEmpty()) {
                \App\Models\UnresolvedSearchLog::create([
                    'query' => strip_tags($query),
                    'ip_address' => $request->ip(),
                    'user_agent' => substr($request->userAgent(), 0, 500),
                ]);
            }

        } else {
            // Tampilkan semua jika tidak ada pencarian
            $cases = RetirementCase::where('is_published', true)->latest()->paginate(10);
        }

        // Get unique popular tags
        $allTags = collect();
        RetirementCase::where('is_published', true)->pluck('tags')->filter()->each(function($tags) use ($allTags) {
            if (is_array($tags)) {
                foreach ($tags as $tag) {
                    $allTags->push($tag);
                }
            }
        });
        // Ambil 12 tag paling sering muncul
        $popularTags = $allTags->countBy()->sortDesc()->take(12)->keys()->toArray();

        $news = Post::dataSide()->get();

        return view('website.pages.services.konsultasi-pensiun', compact('cases', 'query', 'hasSearched', 'news', 'popularTags'));
    }

    public function suggest(Request $request)
    {
        $query = $request->input('q');
        
        if (empty(trim($query)) || strlen($query) < 2) {
            return response()->json([]);
        }

        $cases = RetirementCase::where('is_published', true)
            ->where(function($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                  ->orWhere('tags', 'like', "%{$query}%");
            })
            ->select('title')
            ->latest()
            ->take(5)
            ->get()
            ->pluck('title');

        return response()->json($cases);
    }
}
