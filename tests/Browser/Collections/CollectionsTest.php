<?php

namespace Sprucewire\Tests\Browser\Collections;

use Laravel\Dusk\Browser;
use Livewire\Livewire;
use Sprucewire\Tests\Browser\TestCase;

class CollectionsTest extends TestCase
{
    /** @test */
    public function it_displays_correct_collection_output_for_both()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, CollectionsComponent::class)
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4])
                    ;
        });
    }

    /** @test */
    public function it_can_add_and_remove_collection_elements_from_livewire()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, CollectionsComponent::class)
                    // Check all starting values are ok
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4])

                    // Test changing collections from Livewire
                    ->waitForLivewire()->click('@livewire-add')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5])
                    ->waitForLivewire()->click('@livewire-add')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5,6])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5,6])
                    ->waitForLivewire()->click('@livewire-remove')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5])
                    ->waitForLivewire()->click('@livewire-remove')
                    ->waitForLivewire()->click('@livewire-remove')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3])
                    ;
        });
    }

    /** @test */
    public function it_can_add_and_remove_collection_elements_from_spruce()
    {
        // $this->markTestSkipped('There is a bug when reassigning arrays to spruce where changes are not watched, skip this for now. Noted in README');

        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, CollectionsComponent::class)
                    // Check all starting values are ok
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4])

                    // Test changing collections from Spruce
                    ->waitForLivewire()->click('@spruce-add')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5])
                    ->waitForLivewire()->click('@spruce-add')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5,6])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5,6])
                    ->waitForLivewire()->click('@spruce-remove')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5])
                    ->waitForLivewire()->click('@spruce-add')
                    ->waitForLivewire()->click('@spruce-add')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5,6,7])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5,6,7])

                    ;
        });
    }

    /** @test */
    public function it_can_add_and_remove_collection_elements_alternating()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, CollectionsComponent::class)
                    // Check all starting values are ok
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4])

                    // Test changing collections swapping back and forth
                    ->waitForLivewire()->click('@livewire-add')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5])
                    ->waitForLivewire()->click('@spruce-add')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5,6])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5,6])
                    ->waitForLivewire()->click('@spruce-remove')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5])
                    ->assertDontSeeIn('@livewire-collection-output', 6)
                    ->assertDontSeeIn('@spruce-collection-output', 6)
                    ->waitForLivewire()->click('@livewire-remove')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4])
                    ->assertDontSeeIn('@livewire-collection-output', 5)
                    ->assertDontSeeIn('@spruce-collection-output', 5)
                    ->waitForLivewire()->click('@spruce-add')
                    ->waitForLivewire()->click('@spruce-add')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5,6])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5,6])
                    ->waitForLivewire()->click('@livewire-add')
                    ->waitForLivewire()->click('@livewire-add')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5,6,7,8])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5,6,7,8])
                    ->waitForLivewire()->click('@livewire-remove')
                    ->waitForLivewire()->click('@livewire-remove')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5,6])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5,6])
                    ->assertDontSeeIn('@livewire-collection-output', 8)
                    ->assertDontSeeIn('@spruce-collection-output', 8)
                    ->assertDontSeeIn('@livewire-collection-output', 7)
                    ->assertDontSeeIn('@spruce-collection-output', 7)
                    ->waitForLivewire()->click('@spruce-remove')
                    ->waitForLivewire()->click('@spruce-remove')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4])
                    ->assertDontSeeIn('@livewire-collection-output', 6)
                    ->assertDontSeeIn('@spruce-collection-output', 6)
                    ->assertDontSeeIn('@livewire-collection-output', 5)
                    ->assertDontSeeIn('@spruce-collection-output', 5)

                    ;
        });
    }
}
