<?php

namespace App\Providers;

use App\Admin;
use App\Model\Contact;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Stripe\Stripe;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Stripe::setApiKey(config('services.stripe.secret'));
        Relation::morphMap([
            'contact' => Contact::class,
            'admin' => Admin::class
        ]);
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
