<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\Post;
use App\Models\Announcement;
use App\Models\Service;

class PublicRoutesTest extends TestCase
{
    use RefreshDatabase;

    public function test_landing_page_returns_successful_response(): void
    {
        // Fake the webinar API call so it doesn't try to make an actual HTTP request
        Http::fake([
            config('services.webinar.base_url') . '/*' => Http::response(['data' => []], 200),
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_all_news_page_returns_successful_response(): void
    {
        $response = $this->get('/all-news');
        $response->assertStatus(200);
    }

    public function test_all_article_page_returns_successful_response(): void
    {
        $response = $this->get('/all-article');
        $response->assertStatus(200);
    }

    public function test_announcements_page_returns_successful_response(): void
    {
        $response = $this->get('/announcement');
        $response->assertStatus(200);
    }

    public function test_detail_post_returns_successful_response(): void
    {
        $post = Post::factory()->create();

        $response = $this->get('/detail-post/' . $post->slug);

        $response->assertStatus(200);
    }

    public function test_detail_announcement_returns_successful_response(): void
    {
        $announcement = Announcement::factory()->create();

        $response = $this->get('/detail-announcement/' . encrypt($announcement->id));

        $response->assertStatus(200);
    }

    public function test_static_pages_return_successful_response(): void
    {
        $pages = [
            '/visi-misi',
            '/sejarah',
            '/tusi',
            '/struktur',
            '/pimpinan',
            '/akuntabilitas',
            '/kontak',
            '/layanan',
        ];

        foreach ($pages as $page) {
            $response = $this->get($page);
            $response->assertStatus(200);
        }
    }

    public function test_service_pages_return_successful_response(): void
    {
        // Seed some services to avoid empty paginations causing issues if any
        Service::factory()->count(3)->create(['category' => 'pensiun']);
        
        $pages = [
            '/layanan/penetapan-nip-nipppk',
            '/layanan/cltn',
            '/layanan/kenaikan-pangkat',
            '/layanan/peninjauan-masa-kerja',
            '/layanan/mutasi',
            '/layanan/pencantuman-gelar',
            '/layanan/pensiun',
            '/layanan/pengaktifan-pns',
            '/layanan/pengangkatan-cpns',
            '/layanan/peremajaan-data',
            '/layanan/fasilitasi-seleksi-metode-cat',
        ];

        foreach ($pages as $page) {
            $response = $this->get($page);
            $response->assertStatus(200);
        }
    }
}
