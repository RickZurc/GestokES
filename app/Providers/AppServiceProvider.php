<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Order;
use App\Observers\OrderObserver;

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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Order::observe(OrderObserver::class);

        Schema::defaultStringLength(191);

        if (! $this->app->runningInConsole()) {
            // 'key' => 'value'
            $settings = Setting::all('key', 'value')
                ->keyBy('key')
                ->transform(function ($setting) {
                    return $setting->value;
                })
                ->toArray();
            config([
               'settings' => $settings
            ]);

            config(['app.name' => config('settings.app_name')]);
        }

        Paginator::useBootstrap();

    }
}
