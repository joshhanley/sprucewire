<?php

namespace Sprucewire\Tests\Browser\EloquentCollections;

use Laravel\Dusk\Browser;
use Livewire\Livewire;
use Sprucewire\Tests\Browser\Models\Item;
use Sprucewire\Tests\Browser\TestCase;

class EloquentCollectionsTest extends TestCase
{
    protected function defineDatabaseMigrations()
    {
        $this->loadMigrationsFrom($this->packagePath . '/database/migrations');
    }

    /** @test */
    public function it_displays_correct_collection_output_for_both()
    {
        Item::create(['name' => 'test1', 'description' => 'Test 1 description']);
        Item::create(['name' => 'test2', 'description' => 'Test 2 description']);
        Item::create(['name' => 'test3', 'description' => 'Test 3 description']);

        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, EloquentCollectionsComponent::class)
                    ->assertSeeInOrder('@livewire-collection-output', ['test1', 'test2', 'test3'])
                    ->assertSeeInOrder('@spruce-collection-output', ['test1', 'test2', 'test3'])
                    ;
        });
    }

    /** @test */
    public function it_can_add_and_remove_eloquent_collection_items_from_livewire()
    {
        Item::create(['name' => 'test1', 'description' => 'Test 1 description']);
        Item::create(['name' => 'test2', 'description' => 'Test 2 description']);
        Item::create(['name' => 'test3', 'description' => 'Test 3 description']);

        $this->browse(function (Browser $browser) {
            Livewire::visit($browser, EloquentCollectionsComponent::class)
                    // Check all starting values are ok
                    ->assertSeeInOrder('@livewire-collection-output', ['test1', 'test2', 'test3'])
                    ->assertSeeInOrder('@spruce-collection-output', ['test1', 'test2', 'test3'])

                    // Test changing collections from Livewire
                    ->waitForLivewire()->click('@livewire-add')
                    ->assertSeeInOrder('@livewire-collection-output', ['test1', 'test2', 'test3', 'test4'])
                    ->assertSeeInOrder('@spruce-collection-output', ['test1', 'test2', 'test3', 'test4'])
                    ->waitForLivewire()->click('@livewire-add')
                    ->assertSeeInOrder('@livewire-collection-output', ['test1', 'test2', 'test3', 'test4', 'test5'])
                    ->assertSeeInOrder('@spruce-collection-output', ['test1', 'test2', 'test3', 'test4', 'test5'])
                    ->waitForLivewire()->click('@livewire-remove')
                    ->assertSeeInOrder('@livewire-collection-output', ['test1', 'test2', 'test3', 'test4'])
                    ->assertSeeInOrder('@spruce-collection-output', ['test1', 'test2', 'test3', 'test4'])
                    ->waitForLivewire()->click('@livewire-remove')
                    ->waitForLivewire()->click('@livewire-remove')
                    ->assertSeeInOrder('@livewire-collection-output', ['test1', 'test2'])
                    ->assertSeeInOrder('@spruce-collection-output', ['test1', 'test2'])
                    ;
        });
    }

    /** @test */
    public function it_can_add_and_remove_eloquent_collection_items_from_spruce()
    {
        $this->markTestSkipped('Currently not supported as could cause a security issue');
    }

    /** @test */
    public function it_can_add_and_remove_eloquent_collection_items_alternating()
    {
        $this->markTestSkipped('Currently not supported as could cause a security issue');
    }
}
