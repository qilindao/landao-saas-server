<?php

namespace Module\Tenant\Http\Controllers\V1\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LanDao\LaravelCore\Attributes\Router\Get;
use LanDao\LaravelCore\Attributes\Router\Middleware;
use LanDao\LaravelCore\Controllers\ApiController;

/**
 * 用户信息
 */
#[Middleware(['auth:sanctum', 'auth.tenant', 'userOperate.log'])]
class ProfileController extends ApiController
{
    #[Get(uri:'/user/profile', name: 'user.profile')]
    public function index(Request $request):JsonResponse
    {
        $userInfo = $request->user();
        $userInfo->dept;
        $userInfo->post;
        return $this->success([
            'userInfo' => $userInfo->toArray()
        ]);

    }
}
