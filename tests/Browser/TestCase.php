<?php

namespace Sprucewire\Tests\Browser;

use LivewireDuskTestbench\TestCase as LivewireDuskTestbenchTestCase;

class TestCase extends LivewireDuskTestbenchTestCase
{
    public $packageProviders = [
        SprucewireTestServiceProvider::class,
    ];

    public function configureViewsDirectory()
    {
        // Resolves to 'tests/Browser/views'
        $this->viewsDirectory = __DIR__.'/views';
    }
}
