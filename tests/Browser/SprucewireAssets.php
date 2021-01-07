<?php

namespace Sprucewire\Tests\Browser;

use Livewire\Controllers\CanPretendToBeAFile;

class SprucewireAssets
{
    use CanPretendToBeAFile;

    public function source()
    {
        return $this->pretendResponseIsFile(__DIR__.'/../../dist/sprucewire.umd.js');
    }
}
