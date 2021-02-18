<?php

namespace Sprucewire\Tests\Browser\SubComponents;

use Livewire\Component;

class ChildComponent extends Component
{
    public $name;
    public $unique = 'Something Unique';

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

                <div>
                    <span dusk="livewire-child-unique-output">{{ $unique }}</span>
                </div>
            </div>

            <div x-data x-init="
                $sprucewire.loadStore('main', {
                    name: $sprucewire.entangle('name'),
                    unique: $sprucewire.entangle('unique'),
                })
            ">
                <h1>Spruce Child</h1>

                <input dusk="spruce-child-name-input" x-model="$store.main.name" />

                <div>
                    <span dusk="spruce-child-name-output" x-text="$store.main.name"></span>
                </div>

                <div>
                    <span dusk="spruce-child-unique-output" x-text="$store.main.unique"></span>
                </div>
            </div>
        </div>
        HTML;
    }
}
