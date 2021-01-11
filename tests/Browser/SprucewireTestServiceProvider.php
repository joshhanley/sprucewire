<?php

namespace Sprucewire\Tests\Browser;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route as RouteFacade;

class SprucewireTestServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->runningUnitTests()) {
            RouteFacade::get('/sprucewire.umd.js', [SprucewireAssets::class, 'source']);
            RouteFacade::get('/spruce.umd.js', [SprucewireAssets::class, 'spruce']);
        }
    }
}
