<?php

namespace Sprucewire\Tests\Browser\Scalars;

use Laravel\Dusk\Browser;
use Livewire\Livewire;
use Sprucewire\Tests\Browser\TestCase;

class ScalarsTest extends TestCase
{
    /** @test */
    public function it_can_change_int_variables()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ScalarsComponent::class)
                // ->pause(3000000000)
                    // Check all starting values are ok
                    ->assertSeeIn('@livewire-int-output', 1)
                    ->assertSeeIn('@livewire-string-output', 'string')
                    ->assertSeeIn('@livewire-bool-output', 'true')
                    ->assertSeeIn('@spruce-int-output', 1)
                    ->assertSeeIn('@spruce-string-output', 'string')
                    ->assertSeeIn('@spruce-bool-output', 'true')

                    // Test int Livewire
                    ->waitForLivewire()->click('@livewire-int-input')
                    ->assertSeeIn('@livewire-int-output', 2)
                    ->assertSeeIn('@spruce-int-output', 2)
                    ->waitForLivewire()->click('@livewire-int-input')
                    ->waitForLivewire()->click('@livewire-int-input')
                    ->waitForLivewire()->click('@livewire-int-input')
                    ->assertSeeIn('@livewire-int-output', 5)
                    ->assertSeeIn('@spruce-int-output', 5)

                    // Test int Spruce
                    ->waitForLivewire()->click('@spruce-int-input')
                    ->assertSeeIn('@livewire-int-output', 6)
                    ->assertSeeIn('@spruce-int-output', 6)
                    ->waitForLivewire()->click('@spruce-int-input')
                    ->waitForLivewire()->click('@spruce-int-input')
                    ->waitForLivewire()->click('@spruce-int-input')
                    ->assertSeeIn('@livewire-int-output', 9)
                    ->assertSeeIn('@spruce-int-output', 9)

                    // Test int swapping back and forth
                    ->waitForLivewire()->click('@livewire-int-input')
                    ->assertSeeIn('@livewire-int-output', 10)
                    ->assertSeeIn('@spruce-int-output', 10)
                    ->waitForLivewire()->click('@spruce-int-input')
                    ->assertSeeIn('@livewire-int-output', 11)
                    ->assertSeeIn('@spruce-int-output', 11)
                    ->waitForLivewire()->click('@livewire-int-input')
                    ->assertSeeIn('@livewire-int-output', 12)
                    ->assertSeeIn('@spruce-int-output', 12)
                    ->waitForLivewire()->click('@spruce-int-input')
                    ->assertSeeIn('@livewire-int-output', 13)
                    ->assertSeeIn('@spruce-int-output', 13)
                    ;
        });
    }

    /** @test */
    public function it_can_change_string_variables()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ScalarsComponent::class)
                // ->pause(3000000000)
                    // Check all starting values are ok
                    ->assertSeeIn('@livewire-int-output', 1)
                    ->assertSeeIn('@livewire-string-output', 'string')
                    ->assertSeeIn('@livewire-bool-output', 'true')
                    ->assertSeeIn('@spruce-int-output', 1)
                    ->assertSeeIn('@spruce-string-output', 'string')
                    ->assertSeeIn('@spruce-bool-output', 'true')

                    // Test string Livewire
                    ->waitForLivewire()->type('@livewire-string-input', 'w')
                    ->assertSeeIn('@livewire-string-output', 'w')
                    ->assertSeeIn('@spruce-string-output', 'w')
                    ->waitForLivewire()->append('@livewire-string-input', 'e')
                    ->waitForLivewire()->append('@livewire-string-input', 'l')
                    ->waitForLivewire()->append('@livewire-string-input', 'c')
                    ->assertSeeIn('@livewire-string-output', 'welc')
                    ->assertSeeIn('@spruce-string-output', 'welc')

                    // Test string Spruce
                    ->waitForLivewire()->append('@spruce-string-input', 'o')
                    ->assertSeeIn('@livewire-string-output', 'welco')
                    ->assertSeeIn('@spruce-string-output', 'welco')
                    ->waitForLivewire()->append('@spruce-string-input', 'm')
                    ->waitForLivewire()->append('@spruce-string-input', 'e')
                    ->waitForLivewire()->append('@spruce-string-input', '!')
                    ->assertSeeIn('@livewire-string-output', 'welcome!')
                    ->assertSeeIn('@spruce-string-output', 'welcome!')

                    // Test string swapping back and forth
                    ->waitForLivewire()->type('@livewire-string-input', 'hi')
                    ->assertSeeIn('@livewire-string-output', 'hi')
                    ->assertSeeIn('@spruce-string-output', 'hi')
                    ->waitForLivewire()->type('@spruce-string-input', 'hey')
                    ->assertSeeIn('@livewire-string-output', 'hey')
                    ->assertSeeIn('@spruce-string-output', 'hey')
                    ->waitForLivewire()->type('@livewire-string-input', 'bye')
                    ->assertSeeIn('@livewire-string-output', 'bye')
                    ->assertSeeIn('@spruce-string-output', 'bye')
                    ->waitForLivewire()->type('@spruce-string-input', 'cya')
                    ->assertSeeIn('@livewire-string-output', 'cya')
                    ->assertSeeIn('@spruce-string-output', 'cya')
                    ;
        });
    }
    /** @test */
    public function it_can_change_bool_variables()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ScalarsComponent::class)
                // ->pause(3000000000)
                    // Check all starting values are ok
                    ->assertSeeIn('@livewire-int-output', 1)
                    ->assertSeeIn('@livewire-string-output', 'string')
                    ->assertSeeIn('@livewire-bool-output', 'true')
                    ->assertSeeIn('@spruce-int-output', 1)
                    ->assertSeeIn('@spruce-string-output', 'string')
                    ->assertSeeIn('@spruce-bool-output', 'true')

                    // Test bool Livewire
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

                    // Test bool Spruce
                    ->waitForLivewire()->uncheck('@spruce-bool-input')
                    ->assertSeeIn('@livewire-bool-output', 'false')
                    ->assertSeeIn('@spruce-bool-output', 'false')
                    ->waitForLivewire()->check('@spruce-bool-input')
                    ->assertSeeIn('@livewire-bool-output', 'true')
                    ->assertSeeIn('@spruce-bool-output', 'true')
                    ->waitForLivewire()->uncheck('@spruce-bool-input')
                    ->assertSeeIn('@livewire-bool-output', 'false')
                    ->assertSeeIn('@spruce-bool-output', 'false')
                    ->waitForLivewire()->check('@spruce-bool-input')
                    ->assertSeeIn('@livewire-bool-output', 'true')
                    ->assertSeeIn('@spruce-bool-output', 'true')

                    // Test bool swapping back and forth
                    ->waitForLivewire()->uncheck('@livewire-bool-input')
                    ->assertSeeIn('@livewire-bool-output', 'false')
                    ->assertSeeIn('@spruce-bool-output', 'false')
                    ->waitForLivewire()->check('@spruce-bool-input')
                    ->assertSeeIn('@livewire-bool-output', 'true')
                    ->assertSeeIn('@spruce-bool-output', 'true')
                    ->waitForLivewire()->uncheck('@spruce-bool-input')
                    ->assertSeeIn('@livewire-bool-output', 'false')
                    ->assertSeeIn('@spruce-bool-output', 'false')
                    ->waitForLivewire()->check('@livewire-bool-input')
                    ->assertSeeIn('@livewire-bool-output', 'true')
                    ->assertSeeIn('@spruce-bool-output', 'true')
                    ;
        });
    }
}
