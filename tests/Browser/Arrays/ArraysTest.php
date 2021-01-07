<?php

namespace Sprucewire\Tests\Browser\Arrays;

use Laravel\Dusk\Browser;
use Livewire\Livewire;
use Sprucewire\Tests\Browser\TestCase;

class ArraysTest extends TestCase
{
    /** @test */
    public function it_displays_correct_array_output_for_both()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ArraysComponent::class)
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4])
                    ;
        });
    }

    /** @test */
    public function it_can_add_and_remove_array_elements()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ArraysComponent::class)
                    // Check all starting values are ok
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4])

                    // Test changing arrays from Livewire
                    ->waitForLivewire()->click('@livewire-add')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4])
                    ->waitForLivewire()->click('@livewire-add')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4,5])
                    ->waitForLivewire()->click('@livewire-remove')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4])
                    ->waitForLivewire()->click('@livewire-remove')
                    ->waitForLivewire()->click('@livewire-remove')
                    ->assertSeeInOrder('@livewire-array-output', [1,2])
                    ->assertSeeInOrder('@spruce-array-output', [1,2])



                    // Test changing arrays from Spruce
                    ->waitForLivewire()->click('@spruce-add')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3])
                    ->waitForLivewire()->click('@spruce-add')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4])
                    ->waitForLivewire()->click('@spruce-remove')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3])
                    ->waitForLivewire()->click('@spruce-add')
                    ->waitForLivewire()->click('@spruce-add')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4,5])

                    ;
        });
    }
}
