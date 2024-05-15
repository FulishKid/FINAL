<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Thread;
use App\Models\Vote;
use App\Policies\VotePolicy;
use Illuminate\Support\Facades\Gate;
use App\Policies\CommentPolicy;
use App\Policies\ThreadPolicy;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Vote::class, VotePolicy::class);
        Gate::policy(Thread::class, ThreadPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);

    }
    protected function mapApiRoutes(): void
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

}
