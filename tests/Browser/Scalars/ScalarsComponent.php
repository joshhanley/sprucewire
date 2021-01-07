<?php

namespace Sprucewire\Tests\Browser\Scalars;

use Livewire\Component;

class ScalarsComponent extends Component
{
    public int $intProp = 1;
    public string $stringProp = "string";
    public bool $boolProp = true;

    public function increase()
    {
        $this->intProp++;
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <div>
                <h1>Livewire</h1>

                <button dusk="livewire-int-input" wire:click="increase">Increase Int</button>

                <input dusk="livewire-string-input" type="text" wire:model="stringProp" />

                <input dusk="livewire-bool-input" type="checkbox" wire:model="boolProp" />

                <div>
                    <span dusk="livewire-int-output">{{ $intProp }}</span>
                    <span dusk="livewire-string-output">{{ $stringProp }}</span>
                    <span dusk="livewire-bool-output">{{ $boolProp ? 'true' : 'false' }}</span>
                </div>
            </div>

            <div x-data x-init="
                $sprucewire.registerStore('main', {
                    intProp: $sprucewire.entangle('intProp'),
                    stringProp: $sprucewire.entangle('stringProp'),
                    boolProp: $sprucewire.entangle('boolProp')
                })
            ">
                <h1>Spruce</h1>

                <button dusk="spruce-int-input" x-on:click="$store.main.intProp++">Increase Int</button>

                <input dusk="spruce-string-input" type="text" x-model="$store.main.stringProp" />

                <input dusk="spruce-bool-input" type="checkbox" x-model="$store.main.boolProp" />

                <div>
                    <span dusk="spruce-int-output" x-text="$store.main.intProp"></span>
                    <span dusk="spruce-string-output" x-text="$store.main.stringProp"></span>
                    <span dusk="spruce-bool-output" x-text="$store.main.boolProp"></span>
                </div>
            </div>
        </div>
        HTML;
    }
}
