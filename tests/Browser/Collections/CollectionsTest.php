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
    public function it_can_add_and_remove_collection_elements()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, CollectionsComponent::class)
                    // Check all starting values are ok
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4])

                    // Test changing collections from Livewire
                    ->waitForLivewire()->click('@livewire-add')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4])
                    ->waitForLivewire()->click('@livewire-add')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5])
                    ->waitForLivewire()->click('@livewire-remove')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4])
                    ->waitForLivewire()->click('@livewire-remove')
                    ->waitForLivewire()->click('@livewire-remove')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2])



                    // Test changing collections from Spruce
                    ->waitForLivewire()->click('@spruce-add')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3])
                    ->waitForLivewire()->click('@spruce-add')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4])
                    ->waitForLivewire()->click('@spruce-remove')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3])
                    ->waitForLivewire()->click('@spruce-add')
                    ->waitForLivewire()->click('@spruce-add')
                    ->assertSeeInOrder('@livewire-collection-output', [1,2,3,4,5])
                    ->assertSeeInOrder('@spruce-collection-output', [1,2,3,4,5])

                    ;
        });
    }
}
