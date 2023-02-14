<?php

namespace App\Providers;

use App\Http\View\Composers\ChannelComposers;
use App\Mixins\StrMixin;
use App\Models\Chanal;
use App\Payment\BankPaymentGateway;
use App\Payment\CreditPaymentGateway;
use App\Payment\IPaymentGatewayContract;
use App\PostCardSendingService;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
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
        //Service Container

        $this->app->singleton(IPaymentGatewayContract::class, function ($app) {
            if (request()->has('credit'))
                return new CreditPaymentGateway('usd');
            else
                return new BankPaymentGateway('usd');
        });

        //alias "PostCard" to "PostCardSendingService"
        $this->app->singleton("PostCard", function ($app) {

            return new  PostCardSendingService("USA", 5, 4);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        // every single view
//        View::share( 'channels',Chanal::orderBy('created_at')->get());


        // option 2 Granular view with wildcards
//        View::composer(['channels','posts.*'],function ($view){
//          $view->with("channels",  Chanal::orderBy('created_at')->get());
//        });
//


        // option 3  Dedicated class

        View::composer(['channels', 'posts.*'], ChannelComposers::class);

        Str::macro('partNumber', function ($part) {

            return 'Other-' . substr($part, 0, 3) . '-' . substr($part, 3);
        });

        Str::mixin(new StrMixin(),false);

        ResponseFactory::macro('errorJson', function ($message = " Default Error Message", $error_code = 123) {

            return [
                'message' => $message,
                "error_code" => $error_code
            ];
        });

    }
}
