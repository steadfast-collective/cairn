<?php

namespace App\Tags;

use Statamic\Tags\Tags;
use Illuminate\Support\Facades\Route;

class RouteIs extends Tags
{
    /**
     * The {{ route_is }} tag.
     *
     * @return string|array
     */
    public function index()
    {
        return Route::is($this->params->get('route'));
    }
}
