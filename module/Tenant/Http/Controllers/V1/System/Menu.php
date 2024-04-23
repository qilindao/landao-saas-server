<?php

namespace Module\Tenant\Http\Controllers\V1\System;

use App\Http\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use JoyceZ\LaravelLib\Helpers\ResultHelper;
use Module\Tenant\Http\Requests\System\MenuRequest;
use Module\Tenant\Repositories\System\MenuRepo;

class Menu extends ApiController
{
    public function __construct(protected MenuRepo $menuRepo)
    {
    }

    /**
     * 根据租户套餐获取租户所拥有的菜单权限
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $menuList = $this->menuRepo->getMenuLists();
        return $this->success($menuList, 'success');
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
     * @return JsonResponse
     */
    public function read(int $id): JsonResponse
    {
        $menu = $this->menuRepo->getMenuInfo($id);
        if (!$menu) {
            return $this->badSuccessRequest('菜单权限不存在');
        }
        return $this->success($menu);
    }

    /**
     * 新增菜单权限
     * @param MenuRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function store(MenuRequest $request): JsonResponse
    {
        $ret = $this->menuRepo->addMenu($request->all());
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 更新菜单权限
     * @param int $menuId
     * @param MenuRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function update(int $menuId, MenuRequest $request): JsonResponse
    {
        $ret = $this->menuRepo->updateMenu($menuId, $request->all());
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 删除
     * @param int $menuId
     * @return JsonResponse
     */
    public function destroy(int $menuId): JsonResponse
    {
        $ret = $this->menuRepo->delMenu($menuId);
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 更新某个字段
     * @param MenuRequest $request
     * @param int $menuId
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function modifyFiled(MenuRequest $request, int $menuId): JsonResponse
    {
        if ($menuId <= 0) {
            return $this->badSuccessRequest('缺少必要的参数');
        }
        $fieldName = (string)$request->post('field_name');
        $fieldValue = $request->post('field_value');
        $ret = $this->menuRepo->updateSomeField($menuId, $fieldName, $fieldValue);
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }
}
