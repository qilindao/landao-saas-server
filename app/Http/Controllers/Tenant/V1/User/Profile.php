<?php

namespace App\Http\Controllers\Tenant\V1\User;

use App\Http\Controllers\Tenant\TenantController;

class Profile extends TenantController
{
    public function index()
    {
        $userInfo = $this->userModel;
        $userInfo->dept;
        $userInfo->post;
        return $this->success([
            'userInfo' => $userInfo->toArray()
        ]);

    }
}
