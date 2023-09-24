<?php

namespace Riazxrazor\Slybroadcast;


use Illuminate\Support\Facades\Facade;

class SlybroadcastFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Slybroadcast::class;
    }
}