<?php

namespace Zerkxubas\EsewaLaravel\Facades;

use Zerkxubas\EsewaLaravel\Client;
use Illuminate\Support\Facades\Facade;

class Esewa extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Client::class;
    }
}