<?php

namespace Module\Tenant\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Module\Tenant\Repositories\System\OperateLogRepo;
use Symfony\Component\HttpFoundation\Response;

class UserOperateLog
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return Response
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle(Request $request, Closure $next): Response
    {
        //去掉关键字段
        $input = $request->except([
            'password',
            'oldpassword',
            'newpassword',
            'newpassword_confirm',
        ]);
        $operateLogRepo = app()->make(OperateLogRepo::class);

        $user = $request->user();
        $operateLogRepo->create([
            'user_id' => $user->user_id,
            'username' => $user->username,
            'module' => $user->username,//操作模块标题 TODO:是bug
            'from_app' => 'PC',//来源端
            'name' => 'PC',//操作名称
            'request_params' => $input,//请求参数
            'request_method' => strtoupper($request->getMethod()),//请求方法名
            'request_url' => $request->url(),//请求url
            'user_ip' => request()->ip(),//请求url
            'user_agent' => $request->server('HTTP_USER_AGENT'),//浏览器 UA
            'tenant_id' => $user->tenant_id,//请求url
        ]);
        return $next($request);
    }
}
