<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Post;
use App\Models\Announcement;

class SitemapController extends Controller
{
    public function index()
    {
        $sitemap = Sitemap::create()
            ->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
            ->add(Url::create('/all-news')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
            ->add(Url::create('/announcement')->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY))
            ->add(Url::create('/layanan')->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY))
            ->add(Url::create('/visi-misi')->setPriority(0.6)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
            ->add(Url::create('/sejarah')->setPriority(0.6)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY))
            ->add(Url::create('/kontak')->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));

        // Add dynamic posts (using cursor() for memory efficiency on 1M+ records)
        Post::where('status', 1)->cursor()->each(function (Post $post) use ($sitemap) {
            $sitemap->add(
                Url::create("/detail-post/{$post->slug}")
                    ->setLastModificationDate($post->updated_at)
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        });

        // Add dynamic announcements (using cursor() for memory efficiency on 1M+ records)
        Announcement::where('is_active', 1)->cursor()->each(function (Announcement $announcement) use ($sitemap) {
            $sitemap->add(
                Url::create("/detail-announcement/" . encrypt($announcement->id))
                    ->setLastModificationDate($announcement->updated_at)
                    ->setPriority(0.7)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
            );
        });

        return $sitemap->toResponse(request());
    }
}
