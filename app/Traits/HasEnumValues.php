<?php

namespace App\Traits;

use App\Enums\Role;

trait HasEnumValues
{
    public static function getValues() : array
    {
        return array_map(fn($role)=> $role->value,Role::cases());
    }
}
