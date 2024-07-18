<?php

namespace App\Services\Model\Contracts;

use App\Services\Model\ParentModelScope;

trait BelongsToPrimaryModel
{
    abstract public function getRelationshipToPrimaryModel(): string;

    public static function bootBelongsToPrimaryModel()
    {
        static::addGlobalScope(new ParentModelScope());
    }
}
