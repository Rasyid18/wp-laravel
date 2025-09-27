<?php

namespace App\Providers;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\Contracts\Wordpress\UserRepositoryInterface as WordpressUserRepositoryInterface;
use App\Repositories\Contracts\WPConnectionRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\Wordpress\UserRepository as WordpressUserRepository;
use App\Repositories\WPConnectionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(WPConnectionRepositoryInterface::class, WPConnectionRepository::class);

        $this->app->bind(WordpressUserRepositoryInterface::class, WordpressUserRepository::class);
    }

    public function boot() {}
}
