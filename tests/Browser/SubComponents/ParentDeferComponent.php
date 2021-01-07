<?php

namespace Sprucewire\Tests\Browser\SubComponents;

use Livewire\Component;

class ParentDeferComponent extends Component
{
    public $name = "Jim";

    public function render()
    {
        return <<<'HTML'
        <div>
            <div>
                <div>
                    <h1>Livewire Parent</h1>

                    <input dusk="livewire-parent-name-input" type="text" wire:model="name" />

                    <div>
                        <span dusk="livewire-parent-name-output">{{ $name }}</span>
                    </div>

                    <button dusk="refresh-parent-server" wire:click="$refresh" type="button">Refresh Server (parent)</button>
                </div>

                <div x-data x-init="
                    $sprucewire.registerStore('main', {
                        name: $sprucewire.entangle('name').defer
                    })
                ">
                    <h1>Spruce Parent</h1>

                    <input dusk="spruce-parent-name-input" x-model="$store.main.name" />

                    <div>
                        <span dusk="spruce-parent-name-output" x-text="$store.main.name"></span>
                    </div>
                </div>
            </div>

            <livewire:sprucewire.tests.browser.sub-components.child-defer-component key="child-defer" />
        </div>
        HTML;
    }
}
