<?php

namespace Sprucewire\Tests\Browser\Collections;

use Laravel\Dusk\Browser;
use Livewire\Livewire;
use Sprucewire\Tests\Browser\TestCase;

class AssociativeCollectionsTest extends TestCase
{
    /** @test */
    public function it_displays_correct_collection_output_for_both()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, AssociativeCollectionsComponent::class)
                    ->assertSeeInOrder('@livewire-collection-output', ['bob', 'dev', 'livewire'])
                    ->assertSeeInOrder('@spruce-collection-output', ['bob', 'dev', 'livewire'])
                    ;
        });
    }

    /** @test */
    public function it_can_modify_collection_elements_from_livewire()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, AssociativeCollectionsComponent::class)
                    // Check all starting values are ok
                    ->assertSeeInOrder('@livewire-collection-output', ['bob', 'dev', 'livewire'])
                    ->assertSeeInOrder('@spruce-collection-output', ['bob', 'dev', 'livewire'])

                    // Test changing collections from Livewire
                    ->waitForLivewire()->type('@livewire-name-input', 'greg')
                    ->assertSeeInOrder('@livewire-collection-output', ['greg', 'dev', 'livewire'])
                    ->assertSeeInOrder('@spruce-collection-output', ['greg', 'dev', 'livewire'])
                    ->waitForLivewire()->type('@livewire-interest-input', 'alpine')
                    ->assertSeeInOrder('@livewire-collection-output', ['greg', 'dev', 'alpine'])
                    ->assertSeeInOrder('@spruce-collection-output', ['greg', 'dev', 'alpine'])
                    ;
        });
    }

    /** @test */
    public function it_can_modify_collection_elements_from_spruce()
    {
        $this->markTestSkipped('There is a bug when reassigning arrays to spruce where changes are not watched, skip this for now. Noted in README');

        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, AssociativeCollectionsComponent::class)
                    // Check all starting values are ok
                    ->assertSeeInOrder('@livewire-collection-output', ['bob', 'dev', 'livewire'])
                    ->assertSeeInOrder('@spruce-collection-output', ['bob', 'dev', 'livewire'])

                    // Test changing collections from Spruce
                    ->waitForLivewire()->type('@spruce-name-input', 'steve')
                    ->assertSeeInOrder('@livewire-collection-output', ['steve', 'dev', 'livewire'])
                    ->assertSeeInOrder('@spruce-collection-output', ['steve', 'dev', 'livewire'])
                    ->waitForLivewire()->type('@spruce-interest-input', 'spruce')
                    ->assertSeeInOrder('@livewire-collection-output', ['steve', 'dev', 'spruce'])
                    ->assertSeeInOrder('@spruce-collection-output', ['steve', 'dev', 'spruce'])
                    ;
        });
    }
}
