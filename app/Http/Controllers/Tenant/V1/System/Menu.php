<?php

namespace App\Http\Controllers\Tenant\V1\System;

use App\Http\Controllers\ApiController;
use App\Http\Requests\System\MenuRequest;
use App\Services\Models\User\RoleModel;
use App\Services\Repositories\System\MenuRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use JoyceZ\LaravelLib\Helpers\ResultHelper;

class Menu extends ApiController
{
    /**
     * 根据租户套餐获取租户所拥有的菜单权限
     * @param MenuRepo $menuRepo
     * @return JsonResponse
     */
    public function index(Request $request,MenuRepo $menuRepo): JsonResponse
    {
//        tenancy()->initialize($request->current_tenant_id);
//        dd(tenancy()->initialized);
        dd(tenancy()->tenant);
//        $menuList = $menuRepo->getMenuLists($this->tenantPackageModel->menus, $this->tenantPackageModel->is_default);
        return $this->success([], 'success');
    }

    /**
     * 获取接口权限名称
     * @return JsonResponse
     */
    public function power(): JsonResponse
    {
        $routes = Route::getRoutes();
        $routeList = [];
        foreach ($routes->getRoutesByName() as $key => $route) {
            if (Str::is('tenant:*', $key)) {
                $routeList[] = $key;
            }
        }
        return $this->success($routeList);
    }

    /**
     * 详情
     * @param int $id
     * @param MenuRepo $menuRepo
     * @return JsonResponse
     */
    public function read(int $id, MenuRepo $menuRepo): JsonResponse
    {
        $menu = $menuRepo->getMenuInfo($id);
        if (!$menu) {
            return $this->badSuccessRequest('菜单权限不存在');
        }
        return $this->success($menu);
    }

    /**
     * 新增菜单权限
     * @param MenuRequest $request
     * @param MenuRepo $menuRepo
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function store(MenuRequest $request, MenuRepo $menuRepo): JsonResponse
    {
        $ret = $menuRepo->addMenu($request->all());
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 更新菜单权限
     * @param int $menuId
     * @param MenuRequest $request
     * @param MenuRepo $menuRepo
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function update(int $menuId, MenuRequest $request, MenuRepo $menuRepo): JsonResponse
    {
        $ret = $menuRepo->updateMenu($menuId, $request->all());
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    public function destroy(int $menuId, MenuRepo $menuRepo): JsonResponse
    {
        $ret = $menuRepo->delMenu($menuId);
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 更新某个字段
     * @param MenuRequest $request
     * @param int $menuId
     * @param MenuRepo $menuRepo
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function modifyFiled(MenuRequest $request, int $menuId, MenuRepo $menuRepo): JsonResponse
    {
        if ($menuId <= 0) {
            return $this->badSuccessRequest('缺少必要的参数');
        }
        $fieldName = (string)$request->post('field_name');
        $fieldValue = $request->post('field_value');
        $ret = $menuRepo->updateSomeField($menuId, $fieldName, $fieldValue);
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }
}
