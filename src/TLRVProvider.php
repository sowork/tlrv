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
        $this->registerViews();
        $this->registerRoutes();
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

    /**
     * 注册视图
     */
    private function registerViews(){
        $this->loadViewsFrom(__DIR__.'/../resource/views', 'tlrv');

        $this->publishes([
            __DIR__.'/../resource/assets/js' => base_path('resources/assets/js'),
        ], 'tlrv-components');

        $this->publishes([
            __DIR__.'/../resource/ass/' => base_path('resources/assets/js/components'),
        ], 'tlrv-components');

        $this->publishes([
            __DIR__.'/../resource/views' => base_path('resources/views/vendor/tlrv'),
        ], 'tlrv-views');
    }

    private function registerRoutes(){
        $this->loadRoutesFrom(__DIR__.'/../routes/routes.php');
    }

}
