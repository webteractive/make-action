<?php

namespace Glen Bangkila\MakeAction\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Glen Bangkila\MakeAction\MakeAction
 */
class MakeAction extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Glen Bangkila\MakeAction\MakeAction::class;
    }
}
