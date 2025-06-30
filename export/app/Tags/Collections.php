<?php

namespace App\Tags;

use Statamic\Tags\Tags;
use Statamic\Facades\Collection;

class Collections extends Tags
{
    /**
     * The {{ collections }} tag.
     *
     * @return string|array
     */
    public function index()
    {
        return Collection::all();
    }
}
