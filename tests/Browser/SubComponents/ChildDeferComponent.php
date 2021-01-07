<?php

namespace Sprucewire\Tests\Browser\SubComponents;

use Livewire\Component;

class ChildDeferComponent extends Component
{
    public $name = "Different";

    public function render()
    {
        return <<<'HTML'
        <div>
            <div>
                <h1>Livewire Child</h1>

                <input dusk="livewire-child-name-input" type="text" wire:model="name" />

                <div>
                    <span dusk="livewire-child-name-output">{{ $name }}</span>
                </div>

                <button dusk="refresh-child-server" wire:click="$refresh" type="button">Refresh Server (child)</button>
            </div>

            <div x-data x-init="
                $sprucewire.loadStore('main', {
                    name: $sprucewire.entangle('name').defer
                })
            ">
                <h1>Spruce Child</h1>

                <input dusk="spruce-child-name-input" x-model="$store.main.name" />

                <div>
                    <span dusk="spruce-child-name-output" x-text="$store.main.name"></span>
                </div>
            </div>
        </div>
        HTML;
    }
}
