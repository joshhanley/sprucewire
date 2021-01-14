<?php

namespace Sprucewire\Tests\Browser\Collections;

use Laravel\Dusk\Browser;
use Livewire\Livewire;
use Sprucewire\Tests\Browser\TestCase;

class CollectionsDeferTest extends TestCase
{
    /** @test */
    public function it_displays_correct_collection_output_for_both()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, CollectionsDeferComponent::class)
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4])
                    ;
        });
    }

    /** @test */
    public function it_can_add_and_remove_deferred_collection_elements()
    {
        $this->markTestSkipped('There is a bug when reassigning collections from spruce where it becomes an array');

        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, CollectionsDeferComponent::class)
                    // Check all starting values are ok
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4])

                    // Test changing collections from Spruce
                    ->click('@spruce-add')
                    // Give Livewire a chance to respond if it was going to
                    ->pause(100)
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5])
                    ->waitForLivewire()->click('@refresh-server')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5])
                    ->click('@spruce-add')
                    ->pause(100)
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5,6])
                    ->waitForLivewire()->click('@refresh-server')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5,6])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5,6])
                    ->click('@spruce-remove')
                    ->pause(100)
                    ->click('@spruce-remove')
                    ->pause(100)
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5,6])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4])
                    ->assertDontSeeIn('@spruce-collection-output', 5)
                    ->assertDontSeeIn('@spruce-collection-output', 6)
                    ->waitForLivewire()->click('@refresh-server')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4])
                    ->assertDontSeeIn('@livewire-collection-output', 5)
                    ->assertDontSeeIn('@livewire-collection-output', 6)
                    ->assertDontSeeIn('@spruce-collection-output', 5)
                    ->assertDontSeeIn('@spruce-collection-output', 6)

                    // Test changing Livewire just to make sure it's still working
                    ->waitForLivewire()->click('@livewire-add')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5])
                    ->waitForLivewire()->click('@livewire-add')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5,6])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5,6])
                    ->waitForLivewire()->click('@livewire-remove')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5])
                    ->assertDontSeeIn('@livewire-collection-output', 6)
                    ->assertDontSeeIn('@spruce-collection-output', 6)
                    ;
        });
    }
}
