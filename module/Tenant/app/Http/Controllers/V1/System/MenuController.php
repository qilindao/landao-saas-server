<?php

namespace Module\Tenant\Http\Controllers\V1\System;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use LanDao\LaravelCore\Attributes\Inject;
use LanDao\LaravelCore\Attributes\Router\Delete;
use LanDao\LaravelCore\Attributes\Router\Get;
use LanDao\LaravelCore\Attributes\Router\Middleware;
use LanDao\LaravelCore\Attributes\Router\Post;
use LanDao\LaravelCore\Attributes\Router\Put;
use LanDao\LaravelCore\Attributes\Router\WhereNumber;
use LanDao\LaravelCore\Controllers\ApiController;
use LanDao\LaravelCore\Helpers\ResultHelper;
use Module\Tenant\Http\Requests\System\MenuRequest;
use Module\Tenant\Repositories\System\MenuRepo;

#[Middleware(['auth:sanctum', 'auth.tenant', 'userOperate.log'])]
class MenuController extends ApiController
{
    #[Inject]
    protected MenuRepo $menuRepo;

    /**
     * 根据租户套餐获取租户所拥有的菜单权限
     * @return JsonResponse
     */
    #[Get(uri: '/menu', name: 'menu.index')]
    public function index(): JsonResponse
    {
        $menuList = $this->menuRepo->getMenuLists();
        return $this->success($menuList, 'success');
    }

    /**
     * 获取Api权限名称
     * @return JsonResponse
     */
    #[Get(uri: '/menu/power', name: 'menu.power')]
    public function power(): JsonResponse
    {
        $routes = Route::getRoutes();
        $routeList = [];
        foreach ($routes->getRoutesByName() as $key => $route) {
            if (Str::is('app.*', $key)) {
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
    #[Get(uri: '/menu/read/{menuId}', name: 'menu.read'),WhereNumber('menuId')]
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
    #[Post(uri: '/menu/store', name: 'menu.store')]
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
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    #[Put(uri: '/menu/{menuId}', name: 'role.update'), WhereNumber('menuId')]
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
    #[Delete(uri: '/menu/{menuId}', name: 'menu.destroy'), WhereNumber('menuId')]
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
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    #[Post(uri: '/menu/modify/{menuId}', name: 'menu.modifyFiled'), WhereNumber('menuId')]
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
