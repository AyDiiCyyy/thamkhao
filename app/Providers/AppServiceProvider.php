<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CategoryProducts\Interface\CategoryProductInterface;
use App\Repositories\CategoryProducts\Repository\CategoryProductRepository;
use App\Repositories\Products\Interface\ProductInterface;
use App\Repositories\Products\Repository\ProductRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(CategoryProductInterface::class, CategoryProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
