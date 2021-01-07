<?php

namespace Sprucewire\Tests\Browser\SubComponents;

use Laravel\Dusk\Browser;
use Livewire\Livewire;
use Sprucewire\Tests\Browser\TestCase;

class SubComponentsTest extends TestCase
{
    /** @test */
    public function it_can_change_share_state_between_components()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ParentComponent::class)
                    // Check all starting values are ok
                    ->assertSeeIn('@livewire-parent-name-output', 'Jim')
                    ->assertSeeIn('@spruce-parent-name-output', 'Jim')
                    ->assertSeeIn('@livewire-child-name-output', 'Jim')
                    ->assertSeeIn('@spruce-child-name-output', 'Jim')

                    // Make changes from Livewire parent component
                    ->waitForLivewire()->type('@livewire-parent-name-input', 'S')
                    // Give child component time to catch up too
                    ->pause(50)
                    ->assertSeeIn('@livewire-parent-name-output', 'S')
                    ->assertSeeIn('@spruce-parent-name-output', 'S')
                    ->assertSeeIn('@livewire-child-name-output', 'S')
                    ->assertSeeIn('@spruce-child-name-output', 'S')

                    // Make changes from Livewire child component
                    ->waitForLivewire()->append('@livewire-child-name-input', 'q')
                    ->pause(50)
                    ->assertSeeIn('@livewire-parent-name-output', 'Sq')
                    ->assertSeeIn('@spruce-parent-name-output', 'Sq')
                    ->assertSeeIn('@livewire-child-name-output', 'Sq')
                    ->assertSeeIn('@spruce-child-name-output', 'Sq')

                    // Make changes from Spruce parent component
                    ->waitForLivewire()->append('@spruce-parent-name-input', 'u')
                    ->pause(50)
                    ->assertSeeIn('@livewire-parent-name-output', 'Squ')
                    ->assertSeeIn('@spruce-parent-name-output', 'Squ')
                    ->assertSeeIn('@livewire-child-name-output', 'Squ')
                    ->assertSeeIn('@spruce-child-name-output', 'Squ')

                    // Make changes from Spruce child component
                    ->waitForLivewire()->append('@spruce-child-name-input', 'i')
                    ->pause(50)
                    ->assertSeeIn('@livewire-parent-name-output', 'Squi')
                    ->assertSeeIn('@spruce-parent-name-output', 'Squi')
                    ->assertSeeIn('@livewire-child-name-output', 'Squi')
                    ->assertSeeIn('@spruce-child-name-output', 'Squi')

                    // Jumble up the order just to make sure still all ok
                    ->waitForLivewire()->append('@livewire-parent-name-input', 's')
                    ->pause(50)
                    ->assertSeeIn('@livewire-parent-name-output', 'Squis')
                    ->assertSeeIn('@spruce-parent-name-output', 'Squis')
                    ->assertSeeIn('@livewire-child-name-output', 'Squis')
                    ->assertSeeIn('@spruce-child-name-output', 'Squis')
                    ->waitForLivewire()->append('@spruce-child-name-input', 'h')
                    ->pause(50)
                    ->assertSeeIn('@livewire-parent-name-output', 'Squish')
                    ->assertSeeIn('@spruce-parent-name-output', 'Squish')
                    ->assertSeeIn('@livewire-child-name-output', 'Squish')
                    ->assertSeeIn('@spruce-child-name-output', 'Squish')
                    ->waitForLivewire()->append('@livewire-child-name-input', 'y')
                    ->pause(50)
                    ->assertSeeIn('@livewire-parent-name-output', 'Squishy')
                    ->assertSeeIn('@spruce-parent-name-output', 'Squishy')
                    ->assertSeeIn('@livewire-child-name-output', 'Squishy')
                    ->assertSeeIn('@spruce-child-name-output', 'Squishy')
                    ->waitForLivewire()->append('@spruce-parent-name-input', '!')
                    ->pause(50)
                    ->assertSeeIn('@livewire-parent-name-output', 'Squishy!')
                    ->assertSeeIn('@spruce-parent-name-output', 'Squishy!')
                    ->assertSeeIn('@livewire-child-name-output', 'Squishy!')
                    ->assertSeeIn('@spruce-child-name-output', 'Squishy!')
                    ;
        });
    }


    /** @test */
    public function it_can_defer_shared_state_between_components()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ParentDeferComponent::class)
                    // Check all starting values are ok
                    ->assertSeeIn('@livewire-parent-name-output', 'Jim')
                    ->assertSeeIn('@spruce-parent-name-output', 'Jim')
                    ->assertSeeIn('@livewire-child-name-output', 'Different')
                    ->assertSeeIn('@spruce-child-name-output', 'Jim')
                    // Push changes down to child Livewire component
                    ->waitForLivewire()->click('@refresh-child-server')
                    ->assertSeeIn('@livewire-parent-name-output', 'Jim')
                    ->assertSeeIn('@spruce-parent-name-output', 'Jim')
                    ->assertSeeIn('@livewire-child-name-output', 'Jim')
                    ->assertSeeIn('@spruce-child-name-output', 'Jim')

                    // Make changes from Spruce parent component
                    ->type('@spruce-parent-name-input', 'Live')
                    // Give Livewire a chance to respond if it was going to
                    ->pause(100)
                    ->assertSeeIn('@livewire-parent-name-output', 'Jim')
                    ->assertSeeIn('@spruce-parent-name-output', 'Live')
                    ->assertSeeIn('@livewire-child-name-output', 'Jim')
                    ->assertSeeIn('@spruce-child-name-output', 'Live')
                    // Push changes down to parent Livewire component
                    ->waitForLivewire()->click('@refresh-parent-server')
                    ->assertSeeIn('@livewire-parent-name-output', 'Live')
                    ->assertSeeIn('@spruce-parent-name-output', 'Live')
                    ->assertSeeIn('@livewire-child-name-output', 'Jim')
                    ->assertSeeIn('@spruce-child-name-output', 'Live')
                    // Push changes down to child Livewire component
                    ->waitForLivewire()->click('@refresh-child-server')
                    ->assertSeeIn('@livewire-parent-name-output', 'Live')
                    ->assertSeeIn('@spruce-parent-name-output', 'Live')
                    ->assertSeeIn('@livewire-child-name-output', 'Live')
                    ->assertSeeIn('@spruce-child-name-output', 'Live')

                    // Make changes from Spruce child component
                    ->append('@spruce-child-name-input', 'wire')
                    // Give Livewire a chance to respond if it was going to
                    ->pause(100)
                    ->assertSeeIn('@livewire-parent-name-output', 'Live')
                    ->assertSeeIn('@spruce-parent-name-output', 'Livewire')
                    ->assertSeeIn('@livewire-child-name-output', 'Live')
                    ->assertSeeIn('@spruce-child-name-output', 'Livewire')
                    // Push changes down to child Livewire component
                    ->waitForLivewire()->click('@refresh-child-server')
                    ->assertSeeIn('@livewire-parent-name-output', 'Live')
                    ->assertSeeIn('@spruce-parent-name-output', 'Livewire')
                    ->assertSeeIn('@livewire-child-name-output', 'Livewire')
                    ->assertSeeIn('@spruce-child-name-output', 'Livewire')
                    // Push changes down to parent Livewire component
                    ->waitForLivewire()->click('@refresh-parent-server')
                    ->assertSeeIn('@livewire-parent-name-output', 'Livewire')
                    ->assertSeeIn('@spruce-parent-name-output', 'Livewire')
                    ->assertSeeIn('@livewire-child-name-output', 'Livewire')
                    ->assertSeeIn('@spruce-child-name-output', 'Livewire')
                    ;
        });
    }
}
