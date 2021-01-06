<?php

namespace SpruceEntangle\Tests\Browser;

use LivewireDusk\TestCase as LivewireDuskTestCase;

class TestCase extends LivewireDuskTestCase
{
    public $packageProviders = [
        SpruceEntangleTestServiceProvider::class,
    ];

    public function configureViewsDirectory()
    {
        // Resolves to 'tests/Browser/views'
        $this->viewsDirectory = __DIR__.'/views';
    }
}
