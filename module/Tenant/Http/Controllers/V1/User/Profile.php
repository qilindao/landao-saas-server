<?php

namespace Module\Tenant\Http\Controllers\V1\User;

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
