<?php

namespace Mmnijas\DeepSeek;

use Illuminate\Support\ServiceProvider;
use Mmnijas\DeepSeek\Services\DeepSeekService;

class DeepSeekServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('deepseek', function ($app) {
            return new DeepSeekService(config('deepseek'));
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/deepseek.php' => config_path('deepseek.php'),
        ], 'deepseek-config');
    }
}
