<?php

namespace Sprucewire\Tests\Browser\Scalars;

use Laravel\Dusk\Browser;
use Livewire\Livewire;
use Sprucewire\Tests\Browser\TestCase;

class ScalarsDeferTest extends TestCase
{
    /** @test */
    public function it_can_change_deferred_int_variables()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ScalarsDeferComponent::class)
                    // Check all starting values are ok
                    ->assertSeeIn('@livewire-int-output', 1)
                    ->assertSeeIn('@livewire-string-output', 'string')
                    ->assertSeeIn('@livewire-bool-output', 'true')
                    ->assertSeeIn('@spruce-int-output', 1)
                    ->assertSeeIn('@spruce-string-output', 'string')
                    ->assertSeeIn('@spruce-bool-output', 'true')

                    // Test changing Spruce
                    ->click('@spruce-int-input')
                    // Give Livewire a chance to respond if it was going to
                    ->pause(100)
                    ->assertSeeIn('@livewire-int-output', 1)
                    ->assertSeeIn('@spruce-int-output', 2)
                    ->waitForLivewire()->click('@refresh-server')
                    ->assertSeeIn('@livewire-int-output', 2)
                    ->assertSeeIn('@spruce-int-output', 2)
                    ->click('@spruce-int-input')
                    ->pause(100)
                    ->click('@spruce-int-input')
                    ->pause(100)
                    ->click('@spruce-int-input')
                    ->pause(100)
                    ->assertSeeIn('@livewire-int-output', 2)
                    ->assertSeeIn('@spruce-int-output', 5)
                    ->waitForLivewire()->click('@refresh-server')
                    ->assertSeeIn('@livewire-int-output', 5)
                    ->assertSeeIn('@spruce-int-output', 5)

                    // Test changing Livewire just to make sure it's still working
                    ->waitForLivewire()->click('@livewire-int-input')
                    ->assertSeeIn('@livewire-int-output', 6)
                    ->assertSeeIn('@spruce-int-output', 6)
                    ->waitForLivewire()->click('@livewire-int-input')
                    ->assertSeeIn('@livewire-int-output', 7)
                    ->assertSeeIn('@spruce-int-output', 7)
                    ;
        });
    }

    /** @test */
    public function it_can_change_deferred_string_variables()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ScalarsDeferComponent::class)
                    // Check all starting values are ok
                    ->assertSeeIn('@livewire-int-output', 1)
                    ->assertSeeIn('@livewire-string-output', 'string')
                    ->assertSeeIn('@livewire-bool-output', 'true')
                    ->assertSeeIn('@spruce-int-output', 1)
                    ->assertSeeIn('@spruce-string-output', 'string')
                    ->assertSeeIn('@spruce-bool-output', 'true')

                    // Test changing Spruce
                    ->type('@spruce-string-input', 'h')
                    // Give Livewire a chance to respond if it was going to
                    ->pause(100)
                    ->assertSeeIn('@livewire-string-output', 'string')
                    ->assertSeeIn('@spruce-string-output', 'h')
                    ->waitForLivewire()->click('@refresh-server')
                    ->assertSeeIn('@livewire-string-output', 'h')
                    ->assertSeeIn('@spruce-string-output', 'h')
                    ->append('@spruce-string-input', 'e')
                    ->append('@spruce-string-input', 'l')
                    ->append('@spruce-string-input', 'l')
                    ->append('@spruce-string-input', 'o')
                    ->assertSeeIn('@livewire-string-output', 'h')
                    ->assertSeeIn('@spruce-string-output', 'hello')
                    ->waitForLivewire()->click('@refresh-server')
                    ->assertSeeIn('@livewire-string-output', 'hello')
                    ->assertSeeIn('@spruce-string-output', 'hello')

                    // Test changing Livewire just to make sure it's still working
                    ->waitForLivewire()->type('@livewire-string-input', 'work')
                    ->assertSeeIn('@livewire-string-output', 'work')
                    ->assertSeeIn('@spruce-string-output', 'work')
                    ->waitForLivewire()->append('@livewire-string-input', 'ing')
                    ->assertSeeIn('@livewire-string-output', 'working')
                    ->assertSeeIn('@spruce-string-output', 'working')
                    ;
        });
    }
    /** @test */
    public function it_can_change_deferred_bool_variables()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ScalarsDeferComponent::class)
                    // Check all starting values are ok
                    ->assertSeeIn('@livewire-int-output', 1)
                    ->assertSeeIn('@livewire-string-output', 'string')
                    ->assertSeeIn('@livewire-bool-output', 'true')
                    ->assertSeeIn('@spruce-int-output', 1)
                    ->assertSeeIn('@spruce-string-output', 'string')
                    ->assertSeeIn('@spruce-bool-output', 'true')

                    // Test changing Spruce
                    ->uncheck('@spruce-bool-input')
                    // Give Livewire a chance to respond if it was going to
                    ->pause(100)
                    ->assertSeeIn('@livewire-bool-output', 'true')
                    ->assertSeeIn('@spruce-bool-output', 'false')
                    ->waitForLivewire()->click('@refresh-server')
                    ->assertSeeIn('@livewire-bool-output', 'false')
                    ->assertSeeIn('@spruce-bool-output', 'false')
                    ->check('@spruce-bool-input')
                    ->pause(100)
                    ->assertSeeIn('@livewire-bool-output', 'false')
                    ->assertSeeIn('@spruce-bool-output', 'true')
                    ->waitForLivewire()->click('@refresh-server')
                    ->assertSeeIn('@livewire-bool-output', 'true')
                    ->assertSeeIn('@spruce-bool-output', 'true')

                    // Test changing Livewire just to make sure it's still working
                    ->waitForLivewire()->uncheck('@livewire-bool-input')
                    ->assertSeeIn('@livewire-bool-output', 'false')
                    ->assertSeeIn('@spruce-bool-output', 'false')
                    ->waitForLivewire()->check('@livewire-bool-input')
                    ->assertSeeIn('@livewire-bool-output', 'true')
                    ->assertSeeIn('@spruce-bool-output', 'true')
                    ->waitForLivewire()->uncheck('@livewire-bool-input')
                    ->assertSeeIn('@livewire-bool-output', 'false')
                    ->assertSeeIn('@spruce-bool-output', 'false')
                    ->waitForLivewire()->check('@livewire-bool-input')
                    ->assertSeeIn('@livewire-bool-output', 'true')
                    ->assertSeeIn('@spruce-bool-output', 'true')
                    ;
        });
    }
}
