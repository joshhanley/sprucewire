<?php

namespace Sprucewire\Tests\Browser\MultipleChanges;

use Laravel\Dusk\Browser;
use Livewire\Livewire;
use Sprucewire\Tests\Browser\TestCase;

class MultipleChangesTest extends TestCase
{
    /** @test */
    public function it_can_change_multiple_properties_at_same_time()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, MultipleChangesComponent::class)
                    // Check all starting values are ok
                    ->assertSeeIn('@livewire-name-output', 'Bob')
                    ->assertSeeIn('@livewire-location-output', 'Sydney')
                    ->assertSeeIn('@spruce-name-output', 'Bob')
                    ->assertSeeIn('@spruce-location-output', 'Sydney')
                    ->assertSeeIn('@number-of-livewire-requests', 0)

                    // Test changes from Livewire
                    ->waitForLivewire()->click('@livewire-change')
                    ->assertSeeIn('@livewire-name-output', 'Greg')
                    ->assertSeeIn('@livewire-location-output', 'Brisbane')
                    ->assertSeeIn('@spruce-name-output', 'Greg')
                    ->assertSeeIn('@spruce-location-output', 'Brisbane')
                    ->assertSeeIn('@number-of-livewire-requests', 1)

                    // Test changes from Spruce
                    ->waitForLivewire()->click('@spruce-change')
                    ->assertSeeIn('@livewire-name-output', 'Steve')
                    ->assertSeeIn('@livewire-location-output', 'Melbourne')
                    ->assertSeeIn('@spruce-name-output', 'Steve')
                    ->assertSeeIn('@spruce-location-output', 'Melbourne')
                    ->assertSeeIn('@number-of-livewire-requests', 2)
                    ;
        });
    }
    /** @test */
    public function it_can_defer_multiple_property_changes()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, MultipleChangesDeferComponent::class)
                    // Check all starting values are ok
                    ->assertSeeIn('@livewire-name-output', 'Bob')
                    ->assertSeeIn('@livewire-location-output', 'Sydney')
                    ->assertSeeIn('@spruce-name-output', 'Bob')
                    ->assertSeeIn('@spruce-location-output', 'Sydney')
                    ->assertSeeIn('@number-of-livewire-requests', 0)

                    // Test changes from Spruce
                    ->click('@spruce-change')
                    // Give Livewire a chance to respond if it was going to
                    ->pause(100)
                    ->assertSeeIn('@livewire-name-output', 'Bob')
                    ->assertSeeIn('@livewire-location-output', 'Sydney')
                    ->assertSeeIn('@spruce-name-output', 'Steve')
                    ->assertSeeIn('@spruce-location-output', 'Melbourne')
                    ->assertSeeIn('@number-of-livewire-requests', 0)
                    ->waitForLivewire()->click('@refresh-server')
                    ->assertSeeIn('@livewire-name-output', 'Steve')
                    ->assertSeeIn('@livewire-location-output', 'Melbourne')
                    ->assertSeeIn('@spruce-name-output', 'Steve')
                    ->assertSeeIn('@spruce-location-output', 'Melbourne')
                    ->assertSeeIn('@number-of-livewire-requests', 1)

                    // Test changes from Livewire
                    ->waitForLivewire()->click('@livewire-change')
                    ->assertSeeIn('@livewire-name-output', 'Greg')
                    ->assertSeeIn('@livewire-location-output', 'Brisbane')
                    ->assertSeeIn('@spruce-name-output', 'Greg')
                    ->assertSeeIn('@spruce-location-output', 'Brisbane')
                    ->assertSeeIn('@number-of-livewire-requests', 2)
                    ;
        });
    }
}
