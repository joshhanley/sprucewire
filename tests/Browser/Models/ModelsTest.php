<?php

namespace Sprucewire\Tests\Browser\Models;

use Laravel\Dusk\Browser;
use Livewire\Livewire;
use Sprucewire\Tests\Browser\TestCase;

class ModelsTest extends TestCase
{
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom($this->packagePath . '/database/migrations');
    }

    /** @test */
    public function it_displays_correct_model_output_for_both()
    {
        Item::create([
            'name' => 'test1',
            'description' => 'Test 1 description'
            ]);

        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ModelsComponent::class)
                    ->assertSeeIn('@livewire-name-output', 'test1')
                    ->assertSeeIn('@livewire-description-output', 'Test 1 description')
                    ->assertSeeIn('@spruce-name-output', 'test1')
                    ->assertSeeIn('@spruce-description-output', 'Test 1 description')
                    ;
        });
    }

    /** @test */
    public function model_attributes_can_be_changed()
    {
        Item::create([
            'name' => 'test1',
            'description' => 'Test 1 description'
            ]);

        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, ModelsComponent::class)
                    ->assertSeeIn('@livewire-name-output', 'test1')
                    ->assertSeeIn('@livewire-description-output', 'Test 1 description')
                    ->assertSeeIn('@spruce-name-output', 'test1')
                    ->assertSeeIn('@spruce-description-output', 'Test 1 description')

                    // Test Livewire
                    ->waitForLivewire()->type('@livewire-name-input', 'Sample')
                    ->assertSeeIn('@livewire-name-output', 'Sample')
                    ->assertSeeIn('@spruce-name-output', 'Sample')
                    ->waitForLivewire()->append('@livewire-name-input', '1')
                    ->assertSeeIn('@livewire-name-output', 'Sample1')
                    ->assertSeeIn('@spruce-name-output', 'Sample1')
                    ->waitForLivewire()->type('@livewire-description-input', 'Sample description')
                    ->assertSeeIn('@livewire-description-output', 'Sample description')
                    ->assertSeeIn('@spruce-description-output', 'Sample description')
                    ->waitForLivewire()->append('@livewire-description-input', '!')
                    ->assertSeeIn('@livewire-description-output', 'Sample description!')
                    ->assertSeeIn('@spruce-description-output', 'Sample description!')

                    // Test Spruce
                    ->waitForLivewire()->type('@spruce-name-input', 'Other')
                    ->assertSeeIn('@livewire-name-output', 'Other')
                    ->assertSeeIn('@spruce-name-output', 'Other')
                    ->waitForLivewire()->append('@spruce-name-input', '1')
                    ->assertSeeIn('@livewire-name-output', 'Other1')
                    ->assertSeeIn('@spruce-name-output', 'Other1')
                    ->waitForLivewire()->type('@spruce-description-input', 'None other')
                    ->assertSeeIn('@livewire-description-output', 'None other')
                    ->assertSeeIn('@spruce-description-output', 'None other')
                    ->waitForLivewire()->append('@spruce-description-input', '...')
                    ->assertSeeIn('@livewire-description-output', 'None other...')
                    ->assertSeeIn('@spruce-description-output', 'None other...')

                    // Test swapping back and forth
                    ->waitForLivewire()->type('@livewire-name-input', 'T')
                    ->assertSeeIn('@livewire-name-output', 'T')
                    ->assertSeeIn('@spruce-name-output', 'T')
                    ->waitForLivewire()->append('@spruce-name-input', 'e')
                    ->assertSeeIn('@livewire-name-output', 'Te')
                    ->assertSeeIn('@spruce-name-output', 'Te')
                    ->waitForLivewire()->append('@livewire-name-input', 's')
                    ->assertSeeIn('@livewire-name-output', 'Tes')
                    ->assertSeeIn('@spruce-name-output', 'Tes')
                    ->waitForLivewire()->append('@spruce-name-input', 't')
                    ->assertSeeIn('@livewire-name-output', 'Test')
                    ->assertSeeIn('@spruce-name-output', 'Test')
                    ;
        });
    }
}
