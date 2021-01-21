<?php

namespace Sprucewire\Tests\Browser\Arrays;

use Livewire\Component;

class AssociativeArraysComponent extends Component
{
    public $arrayProp = [
        'name' => 'greg',
        'career' => 'designer',
        'interest' => 'tailwind'
    ];

    public function add()
    {
        $this->arrayProp['sample'] = 'other';
    }

    public function remove()
    {
        array_pop($this->arrayProp);
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <div>
                <h1>Livewire</h1>

                <input dusk="livewire-name-input" type="text" wire:model="arrayProp.name">
                <input dusk="livewire-career-input" type="text" wire:model="arrayProp.career">
                <input dusk="livewire-interest-input" type="text" wire:model="arrayProp.interest">

                <button dusk="livewire-add" wire:click="add" type="button">Add Item</button>
                <button dusk="livewire-remove" wire:click="remove" type="button">Remove Item</button>

                <ul dusk="livewire-array-output">
                    @foreach($arrayProp as $key => $arrayItem)
                        <li wire:key="array-{{ $key }}">{{ $arrayItem }}</li>
                    @endforeach
                </ul>
            </div>

            <div x-data x-init="
                $sprucewire.registerStore('arrayStore', {
                    arrayProp: $sprucewire.entangle('arrayProp')
                })
            ">
                <h1>Spruce</h1>

                <button dusk="spruce-add" x-on:click="$store.arrayStore.arrayProp.random = 'name'" type="button">Add Item</button>
                <button dusk="spruce-remove" x-on:click="delete $store.arrayStore.arrayProp['random']" type="button">Remove Item</button>

                <input dusk="spruce-name-input" type="text" x-model="$store.arrayStore.arrayProp.name">
                <input dusk="spruce-career-input" type="text" x-model="$store.arrayStore.arrayProp.career">
                <input dusk="spruce-interest-input" type="text" x-model="$store.arrayStore.arrayProp.interest">

                <ul dusk="spruce-array-output">
                    <template x-for="(key, index) in Object.keys($store.arrayStore.arrayProp)" :key="index">
                        <li x-text="$store.arrayStore.arrayProp[key]"></li>
                    </template>
                </ul>
            </div>
        </div>
        HTML;
    }
}
