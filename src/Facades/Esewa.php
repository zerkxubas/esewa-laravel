<?php

namespace Zerkbro\EsewaLaravel\Facades;

use Illuminate\Support\Facades\Facade;

class Esewa extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'esewa';
    }
}