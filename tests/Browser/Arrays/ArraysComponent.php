<?php

namespace Sprucewire\Tests\Browser\Arrays;

use Livewire\Component;

class ArraysComponent extends Component
{
    public $arrayProp = [1,2,3,4];

    public function add()
    {
        $this->arrayProp[] = count($this->arrayProp) + 1;
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

                <button dusk="spruce-add" x-on:click="$store.arrayStore.arrayProp.push($store.arrayStore.arrayProp.length + 1)" type="button">Add Item</button>
                <button dusk="spruce-remove" x-on:click="$store.arrayStore.arrayProp.pop()" type="button">Remove Item</button>

                <ul dusk="spruce-array-output">
                    <template x-for="(arrayItem, index) in $store.arrayStore.arrayProp" :key="index">
                        <li x-text="arrayItem"></li>
                    </template>
                </ul>
            </div>
        </div>
        HTML;
    }
}
