<?php

namespace Sprucewire\Tests\Browser\Collections;

use Livewire\Component;

class AssociativeCollectionsComponent extends Component
{
    public $collectionProp;

    public function mount()
    {
        $this->collectionProp = collect([
            'name' => 'bob',
            'career' => 'dev',
            'interest' => 'livewire'
        ]);
    }

    public function add()
    {
        $this->collectionProp = $this->collectionProp->merge([
            'sample' => 'test'
        ]);
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

                <input dusk="livewire-name-input" type="text" wire:model="collectionProp.name">
                <input dusk="livewire-career-input" type="text" wire:model="collectionProp.career">
                <input dusk="livewire-interest-input" type="text" wire:model="collectionProp.interest">

                <button dusk="livewire-add" type="button" wire:click="add">Add</button>
                <button dusk="livewire-remove" type="button" wire:click="remove">Remove</button>
                <ul dusk="livewire-collection-output">
                    @foreach($collectionProp as $key => $collectionItem)
                        <li wire:key="collection-{{ $key }}">{{ $key }} - {{ $collectionItem }}</li>
                    @endforeach
                </ul>
            </div>

            <div x-data x-init="
                $sprucewire.registerStore('collectionStore', {
                    collectionProp: $sprucewire.entangle('collectionProp')
                });

                console.log(Object.assign({},$store.collectionStore.collectionProp))
            ">
                <h1>Spruce</h1>

                <input dusk="spruce-name-input" type="text" x-model="$store.collectionStore.collectionProp.name">
                <input dusk="spruce-career-input" type="text" x-model="$store.collectionStore.collectionProp.career">
                <input dusk="spruce-interest-input" type="text" x-model="$store.collectionStore.collectionProp.interest">

                <ul dusk="spruce-collection-output">
                    <template x-for="(collectionItem, index) in Object.keys($store.collectionStore.collectionProp)" :key="index">
                        <li x-text="collectionItem + ' - ' + $store.collectionStore.collectionProp[collectionItem]"></li>
                    </template>
                </ul>
            </div>
        </div>
        HTML;
    }
}
