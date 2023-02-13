<?php

namespace App\Providers;

use App\Payment\BankPaymentGateway;
use App\Payment\CreditPaymentGateway;
use App\Payment\IPaymentGatewayContract;
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

        $this->app->singleton(IPaymentGatewayContract::class, function ($app) {
            if (request()->has('credit'))
                return new CreditPaymentGateway('usd');
            else
                return new BankPaymentGateway('usd');
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
