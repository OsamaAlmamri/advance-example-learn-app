<?php

namespace App\Providers;

use App\Repositories\CustomerRepository;
use App\Repositories\IRepository;
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
        //

        $this->app->bind(IRepository::class,CustomerRepository::class );
    }
}
