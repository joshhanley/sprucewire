<?php

namespace Sprucewire\Tests\Browser\Arrays;

use Laravel\Dusk\Browser;
use Livewire\Livewire;
use Sprucewire\Tests\Browser\TestCase;

class ArraysTest extends TestCase
{
    /** @test */
    public function it_runs()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ArraysComponent::class)
                    ->pause(300000)
                    ;
        });
    }
}
