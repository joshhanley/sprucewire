<?php

namespace Sprucewire\Tests\Browser\Models;

use Livewire\Component;
use Sprucewire\Tests\Browser\Models\Item;

class ModelsComponent extends Component
{
    public Item $item;
    public $other;

    protected $rules = [
        'item.name' => 'sometimes',
        'item.description' => 'sometimes',
    ];

    public function mount()
    {
        $this->item = Item::firstOrFail();
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <div>
                <h1>Livewire</h1>

                <div>
                    <input dusk="livewire-name-input" wire:model="item.name" />
                    <input dusk="livewire-description-input" wire:model="item.description" />
                </div>

                <div>
                    <span dusk="livewire-name-output">{{ $item->name }}</span>
                    <span dusk="livewire-description-output">{{ $item->description }}</span>
                </div>
            </div>

            <div x-data x-init="
                $sprucewire.registerStore('modelStore', {
                    name: $sprucewire.entangle('item.name'),
                    description: $sprucewire.entangle('item.description')
                })
            ">
                <h1>Spruce</h1>

                <div>
                    <input dusk="spruce-name-input" x-model="$store.modelStore.name" />
                    <input dusk="spruce-description-input" x-model="$store.modelStore.description" />
                </div>

                <div>
                    <span dusk="spruce-name-output" x-text="$store.modelStore.name"></span>
                    <span dusk="spruce-description-output" x-text="$store.modelStore.description"></span>
                </div>
            </div>
        </div>
        HTML;
    }
}
