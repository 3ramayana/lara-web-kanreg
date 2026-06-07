<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchAndSitemapTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_returns_successful_response(): void
    {
        $this->withoutExceptionHandling();
        $response = $this->get('/search?q=pensiun');
        $response->assertStatus(200);
    }

    public function test_sitemap_returns_successful_response(): void
    {
        $response = $this->get('/sitemap.xml');
        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'text/xml; charset=UTF-8');
    }
}
