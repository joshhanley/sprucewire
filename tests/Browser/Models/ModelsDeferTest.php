<?php

namespace Sprucewire\Tests\Browser\Models;

use Laravel\Dusk\Browser;
use Livewire\Livewire;
use Sprucewire\Tests\Browser\TestCase;

class ModelsDeferTest extends TestCase
{
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom($this->packagePath . '/database/migrations');
    }

    /** @test */
    public function it_displays_correct_model_output_for_both()
    {
        Item::create([
            'name' => 'new',
            'description' => 'New description'
            ]);

        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ModelsDeferComponent::class)
                    ->assertSeeIn('@livewire-name-output', 'new')
                    ->assertSeeIn('@livewire-description-output', 'New description')
                    ->assertSeeIn('@spruce-name-output', 'new')
                    ->assertSeeIn('@spruce-description-output', 'New description')
                    ;
        });
    }

    /** @test */
    public function model_attributes_changes_can_be_deferred()
    {
        Item::create([
            'name' => 'new',
            'description' => 'New description'
            ]);

        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ModelsDeferComponent::class)
                    ->assertSeeIn('@livewire-name-output', 'new')
                    ->assertSeeIn('@livewire-description-output', 'New description')
                    ->assertSeeIn('@spruce-name-output', 'new')
                    ->assertSeeIn('@spruce-description-output', 'New description')

                    // Test changing Spruce
                    ->type('@spruce-name-input', 'Coffee')
                    // Give Livewire a chance to respond if it was going to
                    ->pause(100)
                    ->assertSeeIn('@livewire-name-output', 'new')
                    ->assertSeeIn('@spruce-name-output', 'Coffee')
                    ->waitForLivewire()->click('@refresh-server')
                    ->assertSeeIn('@livewire-name-output', 'Coffee')
                    ->assertSeeIn('@spruce-name-output', 'Coffee')
                    ->append('@spruce-name-input', '!!!')
                    ->pause(100)
                    ->assertSeeIn('@livewire-name-output', 'Coffee')
                    ->assertSeeIn('@spruce-name-output', 'Coffee!!!')
                    ->waitForLivewire()->click('@refresh-server')
                    ->assertSeeIn('@livewire-name-output', 'Coffee!!!')
                    ->assertSeeIn('@spruce-name-output', 'Coffee!!!')
                    ->type('@spruce-description-input', 'Essential')
                    ->pause(100)
                    ->assertSeeIn('@livewire-description-output', 'New description')
                    ->assertSeeIn('@spruce-description-output', 'Essential')
                    ->waitForLivewire()->click('@refresh-server')
                    ->assertSeeIn('@livewire-description-output', 'Essential')
                    ->assertSeeIn('@spruce-description-output', 'Essential')

                    // Test changing Livewire just to make sure it's still working
                    ->waitForLivewire()->type('@livewire-name-input', 'Cup')
                    ->assertSeeIn('@livewire-name-output', 'Cup')
                    ->assertSeeIn('@spruce-name-output', 'Cup')
                    ->waitForLivewire()->append('@livewire-name-input', 's')
                    ->assertSeeIn('@livewire-name-output', 'Cups')
                    ->assertSeeIn('@spruce-name-output', 'Cups')
                    ->waitForLivewire()->type('@livewire-description-input', 'To drink')
                    ->assertSeeIn('@livewire-description-output', 'To drink')
                    ->assertSeeIn('@spruce-description-output', 'To drink')
                    ->waitForLivewire()->append('@livewire-description-input', ' coffee')
                    ->assertSeeIn('@livewire-description-output', 'To drink coffee')
                    ->assertSeeIn('@spruce-description-output', 'To drink coffee')
                    ;
        });
    }
}
