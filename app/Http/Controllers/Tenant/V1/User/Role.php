<?php

namespace App\Http\Controllers\Tenant\V1\User;

use App\Http\Controllers\ApiController;
use App\Http\Requests\User\RoleRequest;
use App\Services\Repositories\User\RoleRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JoyceZ\LaravelLib\Helpers\ResultHelper;

class Role extends ApiController
{
    public function index(Request $request, RoleRepo $roleRepo): JsonResponse
    {
        $ret = $roleRepo->getLists($request->all());
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
     * 新增角色
     * @param RoleRequest $request
     * @param RoleRepo $roleRepo
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function store(RoleRequest $request, RoleRepo $roleRepo): JsonResponse
    {
        $ret = $roleRepo->addRole($request->all());
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 更新角色
     * @param int $roleId
     * @param RoleRequest $request
     * @param RoleRepo $roleRepo
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function update(int $roleId, RoleRequest $request, RoleRepo $roleRepo): JsonResponse
    {
        $ret = $roleRepo->updateRole($roleId, $request->all());
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 删除
     * @param int $roleId
     * @param RoleRepo $roleRepo
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function destroy(int $roleId, RoleRepo $roleRepo): JsonResponse
    {
        $ret = $roleRepo->deleteRole($roleId);
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 更新某字段
     * @param RoleRequest $request
     * @param int $roleId
     * @param RoleRepo $roleRepo
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function modifyFiled(RoleRequest $request, int $roleId, RoleRepo $roleRepo): JsonResponse
    {
        if ($roleId <= 0) {
            return $this->badSuccessRequest('缺少必要的参数');
        }
        $fieldName = (string)$request->post('field_name');
        $fieldValue = $request->post('field_value');
        $ret = $roleRepo->updateSomeField($roleId, $fieldName, $fieldValue);
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }
}
