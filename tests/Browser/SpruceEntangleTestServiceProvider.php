<?php

namespace SpruceEntangle\Tests\Browser;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route as RouteFacade;

class SpruceEntangleTestServiceProvider extends ServiceProvider
{
    public function register()
    {
        if ($this->app->runningUnitTests()) {
            RouteFacade::get('/spruce-entangle.js', [SpruceEntangleAssets::class, 'source']);
        }
    }
}
