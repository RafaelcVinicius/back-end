<?php

namespace App\Providers;

use App\Repositories\BcbSgsRepository;
use App\Repositories\Contracts\BcbSgsInterface;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(
            BcbSgsInterface::class,
            BcbSgsRepository::class
        );
    }
}