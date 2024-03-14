<?php

namespace App\Services\Models\Contracts;

interface Tenant
{
    /** 获取用于识别租户主键的名称. */
    public function getTenantKeyName(): string;

    /** 获取用于识别租户主键值. */
    public function getTenantKey();

    /** Get the value of an internal key. */
    public function getInternal(string $key);

    /** Set the value of an internal key. */
    public function setInternal(string $key, $value);

    /** Run a callback in this tenant's environment. */
    public function run(callable $callback);

}
