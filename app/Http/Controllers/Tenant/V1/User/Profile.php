<?php

namespace App\Http\Controllers\Tenant\V1\User;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class Profile extends ApiController
{
    public function index(Request $request)
    {
        $userInfo = $request->user();
        $userInfo->dept;
        $userInfo->post;
        return $this->success([
            'userInfo' => $userInfo->toArray()
        ]);

    }
}
