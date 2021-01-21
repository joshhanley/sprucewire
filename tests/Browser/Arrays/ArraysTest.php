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
    public function it_can_add_and_remove_array_elements_from_livewire()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ArraysComponent::class)
                    // Check all starting values are ok
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4])

                    // Test changing arrays from Livewire
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
                    ->waitForLivewire()->click('@livewire-remove')
                    ->waitForLivewire()->click('@livewire-remove')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3])
                    ->assertDontSeeIn('@livewire-array-output', 5)
                    ->assertDontSeeIn('@spruce-array-output', 5)
                    ->assertDontSeeIn('@livewire-array-output', 4)
                    ->assertDontSeeIn('@spruce-array-output', 4)
                    ;
        });
    }

    /** @test */
    public function it_can_add_and_remove_array_elements_from_spruce()
    {
        // $this->markTestSkipped('There is a bug when reassigning arrays to spruce where changes are not watched, skip this for now. Noted in README');

        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ArraysComponent::class)
                    // Check all starting values are ok
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4])

                    // Test changing arrays from Spruce
                    ->waitForLivewire()->click('@spruce-add')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4,5])
                    ->waitForLivewire()->click('@spruce-add')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4,5,6])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4,5,6])
                    ->waitForLivewire()->click('@spruce-remove')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4,5])
                    ->assertDontSeeIn('@livewire-array-output', 6)
                    ->assertDontSeeIn('@spruce-array-output', 6)
                    ->waitForLivewire()->click('@spruce-add')
                    ->waitForLivewire()->click('@spruce-add')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4,5,6,7])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4,5,6,7])
                    ;
        });
    }

    /** @test */
    public function it_can_add_and_remove_array_elements_alternating()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ArraysComponent::class)
                    // Check all starting values are ok
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4])

                    // Test changing arrays swapping back and forth
                    ->waitForLivewire()->click('@livewire-add')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4,5])
                    ->waitForLivewire()->click('@spruce-add')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4,5,6])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4,5,6])
                    ->waitForLivewire()->click('@spruce-remove')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4,5])
                    ->assertDontSeeIn('@livewire-array-output', 6)
                    ->assertDontSeeIn('@spruce-array-output', 6)
                    ->waitForLivewire()->click('@livewire-remove')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4])
                    ->assertDontSeeIn('@livewire-array-output', 5)
                    ->assertDontSeeIn('@spruce-array-output', 5)
                    ->waitForLivewire()->click('@spruce-add')
                    ->waitForLivewire()->click('@spruce-add')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4,5,6])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4,5,6])
                    ->waitForLivewire()->click('@livewire-add')
                    ->waitForLivewire()->click('@livewire-add')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4,5,6,7,8])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4,5,6,7,8])
                    ->waitForLivewire()->click('@livewire-remove')
                    ->waitForLivewire()->click('@livewire-remove')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4,5,6])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4,5,6])
                    ->assertDontSeeIn('@livewire-array-output', 8)
                    ->assertDontSeeIn('@spruce-array-output', 8)
                    ->assertDontSeeIn('@livewire-array-output', 7)
                    ->assertDontSeeIn('@spruce-array-output', 7)
                    ->waitForLivewire()->click('@spruce-remove')
                    ->waitForLivewire()->click('@spruce-remove')
                    ->assertSeeInOrder('@livewire-array-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-array-output', [1,2,3,4])
                    ->assertDontSeeIn('@livewire-array-output', 6)
                    ->assertDontSeeIn('@spruce-array-output', 6)
                    ->assertDontSeeIn('@livewire-array-output', 5)
                    ->assertDontSeeIn('@spruce-array-output', 5)
                    ;
        });
    }
}
