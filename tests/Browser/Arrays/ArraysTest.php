<?php

namespace SpruceEntangle\Tests\Browser\Arrays;

use Laravel\Dusk\Browser;
use Livewire\Livewire;
use SpruceEntangle\Tests\Browser\TestCase;

class ArraysTest extends TestCase
{
    /** @test */
    public function it_runs()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ArraysComponent::class)
                    ->pause(30000)
                    ;
        });
    }
}
