<?php

// app/Providers/AppServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Contracts\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Contracts\OrderRepositoryInterface;
use App\Repositories\OrderRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }

    public function boot()
    {
        //
    }
}
