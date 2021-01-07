<?php

namespace Sprucewire\Tests\Browser\PreloadedSubComponents;

use Livewire\Component;

class PreloadedParentComponent extends Component
{
    public $name = "Bob";

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

            <livewire:sprucewire.tests.browser.preloaded-sub-components.preloaded-child-component :name="$name" />
        </div>
        HTML;
    }
}
