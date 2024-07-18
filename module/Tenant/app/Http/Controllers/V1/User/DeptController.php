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
use Module\Tenant\Http\Requests\User\DeptRequest;
use Module\Tenant\Repositories\User\DeptRepo;

/**
 * 组织部门
 */
#[Middleware(['auth:sanctum', 'auth.tenant', 'userOperate.log'])]
class DeptController extends ApiController
{
    #[Inject]
    protected DeptRepo $deptRepo;

    /**
     * 获取所有部门
     * @param Request $request
     * @return JsonResponse
     */
    #[Get(uri: '/dept', name: 'dept.index')]
    public function index(Request $request): JsonResponse
    {
        return $this->success($this->deptRepo->getLists($request->all()));
    }

    /**
     * 新增部门
     * @param DeptRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    #[Post(uri: '/dept/store', name: 'dept.store')]
    public function store(DeptRequest $request): JsonResponse
    {
        $ret = $this->deptRepo->addDept($request->all());
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 更新部门
     * @param int $deptId
     * @param DeptRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    #[Put(uri: '/dept/{deptId}', name: 'dept.update'), WhereNumber('deptId')]
    public function update(int $deptId, DeptRequest $request): JsonResponse
    {
        $ret = $this->deptRepo->updateDept($deptId, $request->all());
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 删除
     * @param int $deptId
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    #[Delete(uri: '/dept/{deptId}', name: 'dept.destroy'), WhereNumber('deptId')]
    public function destroy(int $deptId): JsonResponse
    {
        $ret = $this->deptRepo->deleteDept($deptId);
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 更新某字段
     * @param DeptRequest $request
     * @param int $deptId
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    #[Post(uri: '/dept/modify/{deptId}', name: 'dept.modifyFiled'), WhereNumber('deptId')]
    public function modifyFiled(DeptRequest $request, int $deptId): JsonResponse
    {
        if ($deptId <= 0) {
            return $this->badSuccessRequest('缺少必要的参数');
        }
        $fieldName = (string)$request->post('field_name');
        $fieldValue = $request->post('field_value');
        $ret = $this->deptRepo->updateSomeField($deptId, $fieldName, $fieldValue);
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }
}
