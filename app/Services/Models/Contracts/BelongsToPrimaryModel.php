<?php

namespace App\Services\Models\Contracts;

use App\Services\Models\ParentModelScope;

trait BelongsToPrimaryModel
{
    abstract public function getRelationshipToPrimaryModel(): string;

    public static function bootBelongsToPrimaryModel()
    {
        static::addGlobalScope(new ParentModelScope());
    }
}
