<?php

namespace App\Providers;

use App\Payment\PaymentGateway;
use Illuminate\Support\ServiceProvider;
use PhpParser\Node\Expr\New_;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //

        $this->app->bind(PaymentGateway::class,function ($app){
            return new PaymentGateway('usd');
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
