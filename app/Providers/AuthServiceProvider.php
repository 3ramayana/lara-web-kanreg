<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Policies\AdminPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        \App\Models\User::class => AdminPolicy::class,
        \App\Models\Post::class => AdminPolicy::class,
        \App\Models\Announcement::class => AdminPolicy::class,
        \App\Models\Banner::class => AdminPolicy::class,
        \App\Models\Document::class => AdminPolicy::class,
        \App\Models\Employee::class => AdminPolicy::class,
        \App\Models\LetterIn::class => AdminPolicy::class,
        \App\Models\Question::class => AdminPolicy::class,
        \App\Models\Service::class => AdminPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
