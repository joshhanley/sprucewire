<?php

namespace Sprucewire\Tests\Browser\MultipleChanges;

use Livewire\Component;

class MultipleChangesDeferComponent extends Component
{
    public $name = "Bob";
    public $location = "Sydney";

    public $numberOfLivewireRequests = 0;

    public function hydrate()
    {
        $this->numberOfLivewireRequests++;
    }

    public function change()
    {
        $this->name = "Greg";
        $this->location = "Brisbane";
    }

    public function render()
    {
        return <<<'HTML'
        <div>
            <div>
                <h1>Livewire</h1>

                <button dusk="livewire-change" wire:click="change">Change Livewire Properties</button>

                <div>
                    <span dusk="livewire-name-output">{{ $name }}</span>
                    <span dusk="livewire-location-output">{{ $location }}</span>
                </div>

                <div dusk="number-of-livewire-requests">{{ $numberOfLivewireRequests }}</div>

                <button dusk="refresh-server" wire:click="$refresh" type="button">Refresh Server</button>
            </div>

            <div x-data x-init="
                $sprucewire.registerStore('main', {
                    name: $sprucewire.entangle('name').defer,
                    location: $sprucewire.entangle('location').defer
                })
            ">
                <h1>Spruce</h1>

                <button dusk="spruce-change" x-on:click="$store.main.name = 'Steve'; $store.main.location = 'Melbourne'">Change Spruce Properties</button>

                <div>
                    <span dusk="spruce-name-output" x-text="$store.main.name"></span>
                    <span dusk="spruce-location-output" x-text="$store.main.location"></span>
                </div>
            </div>
        </div>
        HTML;
    }
}
