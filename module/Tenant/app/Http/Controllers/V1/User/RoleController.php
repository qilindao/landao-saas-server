<?php

namespace Module\Tenant\Http\Controllers\V1\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LanDao\LaravelCore\Attributes\Inject;
use LanDao\LaravelCore\Attributes\Router\Delete;
use LanDao\LaravelCore\Attributes\Router\Get;
use LanDao\LaravelCore\Attributes\Router\Middleware;
use LanDao\LaravelCore\Attributes\Router\Post;
use LanDao\LaravelCore\Attributes\Router\Put;
use LanDao\LaravelCore\Attributes\Router\WhereNumber;
use LanDao\LaravelCore\Controllers\ApiController;
use LanDao\LaravelCore\Helpers\ResultHelper;
use Module\Tenant\Http\Requests\User\RoleRequest;
use Module\Tenant\Repositories\User\RoleRepo;

#[Middleware(['auth:sanctum', 'auth.tenant', 'userOperate.log'])]
class RoleController extends ApiController
{
    /**
     *
     * @var RoleRepo
     */
    #[Inject]
    protected RoleRepo $roleRepo;

    #[Get(uri: '/role', name: 'role.index')]
    public function index(Request $request): JsonResponse
    {
        $ret = $this->roleRepo->getLists($request->all());
        return $this->success([
            'pagination' => [
                'total' => $ret['total'],
                'page_size' => $ret['per_page'],
                'current_page' => $ret['current_page'],
            ],
            'list' => $ret['data']
        ]);
    }

    /**
     * 获取全部角色
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    #[Get(uri: '/role/list', name: 'role.list')]
    public function lists(): JsonResponse
    {
        $lists = $this->roleRepo->all(['role_id', 'role_name']);
        return $this->success($lists->toArray());
    }

    /**
     * 新增角色
     * @param RoleRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    #[Post(uri: '/role/store', name: 'role.store')]
    public function store(RoleRequest $request): JsonResponse
    {
        $ret = $this->roleRepo->addRole($request->all());
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 更新角色
     * @param int $roleId
     * @param RoleRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    #[Put(uri: '/role/{roleId}',name: 'role.update'), WhereNumber('roleId')]
    public function update(int $roleId, RoleRequest $request): JsonResponse
    {
        $ret = $this->roleRepo->updateRole($roleId, $request->all());
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 删除
     * @param int $roleId
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    #[Delete(uri: '/role/{roleId}', name: 'role.destroy'), WhereNumber('roleId')]
    public function destroy(int $roleId): JsonResponse
    {
        $ret = $this->roleRepo->deleteRole($roleId);
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 更新某字段
     * @param RoleRequest $request
     * @param int $roleId
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    #[Post(uri: '/role/modify/{roleId}', name: 'role.modifyFiled'), WhereNumber('roleId')]
    public function modifyFiled(RoleRequest $request, int $roleId): JsonResponse
    {
        if ($roleId <= 0) {
            return $this->badSuccessRequest('缺少必要的参数');
        }
        $fieldName = (string)$request->post('field_name');
        $fieldValue = $request->post('field_value');
        $ret = $this->roleRepo->updateSomeField($roleId, $fieldName, $fieldValue);
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 更新权限
     * @param int $roleId
     * @param RoleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    #[Post(uri: '/role/update/auth/{roleId}',name: 'role.updateAuth'), WhereNumber('roleId')]
    public function updateRoleAuth(int $roleId, RoleRequest $request): JsonResponse
    {
        if ($roleId <= 0) {
            return $this->badSuccessRequest('缺少角色信息');
        }
        $menus = $request->post('menus', []);
        $ret = $this->roleRepo->updateRoleAuth($roleId, $menus);
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
    }
}
