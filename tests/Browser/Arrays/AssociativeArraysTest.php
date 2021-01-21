<?php

namespace Sprucewire\Tests\Browser\Arrays;

use Laravel\Dusk\Browser;
use Livewire\Livewire;
use Sprucewire\Tests\Browser\TestCase;

class AssociativeArraysTest extends TestCase
{
    /** @test */
    public function it_displays_correct_associative_array_output_for_both()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, AssociativeArraysComponent::class)
                    ->assertSeeInOrder('@livewire-array-output', ['greg', 'designer', 'tailwind'])
                    ->assertSeeInOrder('@spruce-array-output', ['greg', 'designer', 'tailwind'])
                    ;
        });
    }

    /** @test */
    public function it_can_add_and_remove_associative_array_items_from_livewire()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, AssociativeArraysComponent::class)
                    // Check all starting values are ok
                    ->assertSeeInOrder('@livewire-array-output', ['greg', 'designer', 'tailwind'])
                    ->assertSeeInOrder('@spruce-array-output', ['greg', 'designer', 'tailwind'])

                    // Test changing arrays from Livewire
                    ->waitForLivewire()->click('@livewire-add')
                    ->assertSeeInOrder('@livewire-array-output', ['greg', 'designer', 'tailwind', 'other'])
                    ->assertSeeInOrder('@spruce-array-output', ['greg', 'designer', 'tailwind', 'other'])
                    ->waitForLivewire()->click('@livewire-remove')
                    ->waitForLivewire()->click('@livewire-remove')
                    ->assertSeeInOrder('@livewire-array-output', ['greg', 'designer'])
                    ->assertSeeInOrder('@spruce-array-output', ['greg', 'designer'])
                    ->assertDontSeeIn('@livewire-array-output', 'other')
                    ->assertDontSeeIn('@spruce-array-output', 'other')
                    ->assertDontSeeIn('@livewire-array-output', 'tailwind')
                    ->assertDontSeeIn('@spruce-array-output', 'tailwind')
                    ;
        });
    }

    /** @test */
    public function it_can_add_and_remove_associative_array_items_from_spruce()
    {
        $this->markTestSkipped('There is a bug when deleting an object key from Spruce is not reflected');

        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, AssociativeArraysComponent::class)
                    // Check all starting values are ok
                    ->assertSeeInOrder('@livewire-array-output', ['greg', 'designer', 'tailwind'])
                    ->assertSeeInOrder('@spruce-array-output', ['greg', 'designer', 'tailwind'])

                    // Test changing arrays from Spruce
                    ->waitForLivewire()->click('@spruce-add')
                    ->assertSeeInOrder('@livewire-array-output', ['greg', 'designer', 'tailwind', 'name'])
                    ->assertSeeInOrder('@spruce-array-output', ['greg', 'designer', 'tailwind', 'name'])
                    ->waitForLivewire()->click('@spruce-remove')
                    ->assertSeeInOrder('@livewire-array-output', ['greg', 'designer', 'tailwind'])
                    ->assertSeeInOrder('@spruce-array-output', ['greg', 'designer', 'tailwind'])
                    ->assertDontSeeIn('@livewire-array-output', 'name')
                    ->assertDontSeeIn('@spruce-array-output', 'name')
                    ;
        });
    }

    /** @test */
    public function it_can_add_and_remove_associative_array_items_alternating()
    {
        $this->markTestSkipped('There is a bug when deleting an object key from Spruce is not reflected');
    }

    /** @test */
    public function it_can_modify_individual_associative_array_elements_from_livewire()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, AssociativeArraysComponent::class)
                    // Check all starting values are ok
                    ->assertSeeInOrder('@livewire-array-output', ['greg', 'designer', 'tailwind'])
                    ->assertSeeInOrder('@spruce-array-output', ['greg', 'designer', 'tailwind'])

                    // Test changing arrays from Livewire
                    ->waitForLivewire()->type('@livewire-name-input', 'bob')
                    ->assertSeeInOrder('@livewire-array-output', ['bob', 'designer', 'tailwind'])
                    ->assertSeeInOrder('@spruce-array-output', ['bob', 'designer', 'tailwind'])
                    ->waitForLivewire()->type('@livewire-interest-input', 'laravel')
                    ->assertSeeInOrder('@livewire-array-output', ['bob', 'designer', 'laravel'])
                    ->assertSeeInOrder('@spruce-array-output', ['bob', 'designer', 'laravel'])
                    ;
        });
    }

    /** @test */
    public function it_can_modify_individual_associative_array_elements_from_spruce()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, AssociativeArraysComponent::class)
                    // Check all starting values are ok
                    ->assertSeeInOrder('@livewire-array-output', ['greg', 'designer', 'tailwind'])
                    ->assertSeeInOrder('@spruce-array-output', ['greg', 'designer', 'tailwind'])

                    // Test changing arrays from Livewire
                    ->waitForLivewire()->type('@spruce-name-input', 'john')
                    ->assertSeeInOrder('@livewire-array-output', ['john', 'designer', 'tailwind'])
                    ->assertSeeInOrder('@spruce-array-output', ['john', 'designer', 'tailwind'])
                    ->waitForLivewire()->type('@spruce-interest-input', 'spruce')
                    ->assertSeeInOrder('@livewire-array-output', ['john', 'designer', 'spruce'])
                    ->assertSeeInOrder('@spruce-array-output', ['john', 'designer', 'spruce'])
                    ;
        });
    }

    /** @test */
    public function it_can_modify_individual_associative_array_elements_alternating()
    {
        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, AssociativeArraysComponent::class)
                    // Check all starting values are ok
                    ->assertSeeInOrder('@livewire-array-output', ['greg', 'designer', 'tailwind'])
                    ->assertSeeInOrder('@spruce-array-output', ['greg', 'designer', 'tailwind'])

                    // Test changing arrays swapping back and forth
                    ->waitForLivewire()->type('@livewire-name-input', 'bob')
                    ->assertSeeInOrder('@livewire-array-output', ['bob', 'designer', 'tailwind'])
                    ->assertSeeInOrder('@spruce-array-output', ['bob', 'designer', 'tailwind'])
                    ->waitForLivewire()->type('@spruce-name-input', 'steve')
                    ->assertSeeInOrder('@livewire-array-output', ['steve', 'designer', 'tailwind'])
                    ->assertSeeInOrder('@spruce-array-output', ['steve', 'designer', 'tailwind'])
                    ->waitForLivewire()->type('@livewire-interest-input', 'laravel')
                    ->assertSeeInOrder('@livewire-array-output', ['steve', 'designer', 'laravel'])
                    ->assertSeeInOrder('@spruce-array-output', ['steve', 'designer', 'laravel'])
                    ->waitForLivewire()->type('@spruce-interest-input', 'spruce')
                    ->assertSeeInOrder('@livewire-array-output', ['steve', 'designer', 'spruce'])
                    ->assertSeeInOrder('@spruce-array-output', ['steve', 'designer', 'spruce'])
                    ;
        });
    }
}
