<?php

namespace Sprucewire\Tests\Browser\Collections;

use Livewire\Component;

class CollectionsComponent extends Component
{
    public $collectionProp;

    public function mount()
    {
        $this->collectionProp = collect([1,2,3,4]);
    }

    public function add()
    {
        $this->collectionProp->push($this->collectionProp->count() + 1);
    }

    public function remove()
    {
        $this->collectionProp->pop();
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <div>
                <h1>Livewire</h1>

                <button dusk="livewire-add" wire:click="add" type="button">Add Item</button>
                <button dusk="livewire-remove" wire:click="remove" type="button">Remove Item</button>

                <ul dusk="livewire-collection-output">
                    @foreach($collectionProp as $key => $collectionItem)
                        <li wire:key="collection-{{ $key }}">{{ $collectionItem }}</li>
                    @endforeach
                </ul>
            </div>

            <div x-data x-init="
                $sprucewire.registerStore('collectionStore', {
                    collectionProp: $sprucewire.entangle('collectionProp')
                })
            ">
                <h1>Spruce</h1>

                <button dusk="spruce-add" x-on:click="$store.collectionStore.collectionProp.push($store.collectionStore.collectionProp.length + 1)" type="button">Add Item</button>
                <button dusk="spruce-remove" x-on:click="$store.collectionStore.collectionProp.pop()" type="button">Remove Item</button>

                <ul dusk="spruce-collection-output">
                    <template x-for="(collectionItem, index) in $store.collectionStore.collectionProp" :key="index">
                        <li x-text="collectionItem"></li>
                    </template>
                </ul>
            </div>
        </div>
        HTML;
    }
}
