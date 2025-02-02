<?php

namespace Mmnijas\DeepSeek\Facades;

use Illuminate\Support\Facades\Facade;

class DeepSeek extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'deepseek';
    }
}
