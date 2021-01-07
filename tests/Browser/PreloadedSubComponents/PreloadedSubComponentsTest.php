<?php

namespace Sprucewire\Tests\Browser\PreloadedSubComponents;

use Laravel\Dusk\Browser;
use Livewire\Livewire;
use Sprucewire\Tests\Browser\TestCase;

class PreloadedSubComponentsTest extends TestCase
{
    /** @test */
    public function ensure_no_requests_are_sent_if_child_recieves_initial_data_from_parent()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, PreloadedParentComponent::class)
                    // Check all starting values are ok
                    ->assertSeeIn('@livewire-parent-name-output', 'Bob')
                    ->assertSeeIn('@spruce-parent-name-output', 'Bob')
                    ->assertSeeIn('@livewire-child-name-output', 'Bob')
                    ->assertSeeIn('@spruce-child-name-output', 'Bob')

                    // Give Livewire a chance to respond if it was going to
                    ->pause(100)

                    // Assert no network requests were made
                    ->assertSeeIn('@number-of-livewire-requests', 0)
                    ;
        });
    }
}
