<?php

namespace Sprucewire\Tests\Browser\SubComponents;

use Livewire\Component;

class ParentComponent extends Component
{
    public $name = "Jim";

    public function render()
    {
        return <<<'HTML'
        <div>
            <div>
                <div>
                    <h1>Livewire</h1>

                    <input dusk="livewire-parent-name-input" type="text" wire:model="name" />

                    <div>
                        <span dusk="livewire-parent-name-output">{{ $name }}</span>
                    </div>
                </div>

                <div x-data x-init="
                    $sprucewire.registerStore('main', {
                        name: $sprucewire.entangle('name')
                    })
                ">
                    <h1>Spruce</h1>

                    <input dusk="spruce-parent-name-input" x-model="$store.main.name" />

                    <div>
                        <span dusk="spruce-parent-name-output" x-text="$store.main.name"></span>
                    </div>
                </div>
            </div>

            <livewire:sprucewire.tests.browser.sub-components.child-component />
        </div>
        HTML;
    }
}
