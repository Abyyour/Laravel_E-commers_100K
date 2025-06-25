<?php

namespace App\Providers;

use App\Repositories\CategoryRepository;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\OrderRepositoryInterface;
use App\Repositories\Contracts\PromoCodeRepositoryInterface;
use App\Repositories\Contracts\ShoeRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Repositories\PromoCodeRepository;
use App\Repositories\ShoeRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
   * Register any application services.
   */
    public function register(): void
    {
        //
        $this->app->singleton(CategoryRepositoryInterface::class, CategoryRepository::class);

        $this->app->singleton(ShoeRepositoryInterface::class, ShoeRepository::class);

        $this->app->singleton(OrderRepositoryInterface::class, OrderRepository::class);

        $this->app->singleton(PromoCodeRepositoryInterface::class, PromoCodeRepository::class);
    }
    /**
   * Bootstrap any application services.
   */
    public function boot(): void
    {
        //
    }
}