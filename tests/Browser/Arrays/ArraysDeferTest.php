<?php

namespace Sprucewire\Tests\Browser\Arrays;

use Laravel\Dusk\Browser;
use Livewire\Livewire;
use Sprucewire\Tests\Browser\TestCase;

class ArraysDeferTest extends TestCase
{
    /** @test */
    public function it_displays_correct_array_output_for_both()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ArraysDeferComponent::class)
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4])
                    ;
        });
    }

    /** @test */
    public function it_can_add_and_remove_deferred_array_elements()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ArraysDeferComponent::class)
                    // Check all starting values are ok
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4])

                    // Test changing arrays from Spruce
                    ->click('@spruce-add')
                    // Give Livewire a chance to respond if it was going to
                    ->pause(100)
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4,5])
                    ->waitForLivewire()->click('@refresh-server')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4,5])
                    ->click('@spruce-add')
                    ->pause(100)
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4,5,6])
                    ->waitForLivewire()->click('@refresh-server')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4,5,6])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4,5,6])
                    ->click('@spruce-remove')
                    ->pause(100)
                    ->click('@spruce-remove')
                    ->pause(100)
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4,5,6])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4])
                    ->assertDontSeeIn('@spruce-array-output', 5)
                    ->assertDontSeeIn('@spruce-array-output', 6)
                    ->waitForLivewire()->click('@refresh-server')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4])
                    ->assertDontSeeIn('@livewire-array-output', 5)
                    ->assertDontSeeIn('@livewire-array-output', 6)
                    ->assertDontSeeIn('@spruce-array-output', 5)
                    ->assertDontSeeIn('@spruce-array-output', 6)

                    // Test changing Livewire just to make sure it's still working
                    ->waitForLivewire()->click('@livewire-add')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4,5])
                    ->waitForLivewire()->click('@livewire-add')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4,5,6])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4,5,6])
                    ->waitForLivewire()->click('@livewire-remove')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4,5])
                    ->assertDontSeeIn('@livewire-array-output', 6)
                    ->assertDontSeeIn('@spruce-array-output', 6)
                    ;
        });
    }
}
