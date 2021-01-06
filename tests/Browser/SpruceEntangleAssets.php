<?php

namespace SpruceEntangle\Tests\Browser;

use Livewire\Controllers\CanPretendToBeAFile;

class SpruceEntangleAssets
{
    use CanPretendToBeAFile;

    public function source()
    {
        return $this->pretendResponseIsFile(__DIR__.'/../../dist/spruce-entangle.js');
    }
}
