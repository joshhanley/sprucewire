<?php

namespace Sprucewire\Tests\Browser;

use LivewireDusk\TestCase as LivewireDuskTestCase;

class TestCase extends LivewireDuskTestCase
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
