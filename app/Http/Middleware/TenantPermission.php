<?php

namespace App\Http\Middleware;

use App\Services\Tenancy;
use Closure;
use Illuminate\Http\Request;
use Module\Tenant\Repositories\Tenant\TenantRepo;
use Symfony\Component\HttpFoundation\Response;

class TenantPermission
{

    /** @var callable */
    public static $onFail;

    /** @var Tenancy */
    protected $tenancy;

    public function __construct()
    {
        $this->tenancy = new Tenancy();
    }


    /**
     * 扩展request
     * @param $user
     * @return void
     */
    private function extendRequest($user): void
    {
        Request::macro('tenant', function () use ($user) {
            $tenantRepo = app()->make(TenantRepo::class);
            return $tenantRepo->getInfoById($user->tenant_id);
        });
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth('sanctum')->user();
        $this->tenancy->initialize($user->tenant_id);
        $request->offsetSet('curren_user_id', $user->user_id);
        $request->offsetSet('current_tenant_id', $user->tenant_id);
        $this->extendRequest($user);
        return $next($request);
    }
}
