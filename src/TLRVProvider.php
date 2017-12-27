<?php

namespace Sowork\TLRV;

use Illuminate\Support\ServiceProvider;

class TLRVProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->registerMigration();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('tlrv', function ($app) {
            return new TLRV();
        });


    }


    /**
     * 注册迁移
     */
    private function registerMigration(){
        if(TLRV::$runsMigrations){
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        }

        $this->publishes([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'tlrv-migrations');
    }
}
