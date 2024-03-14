<?php

namespace App\Http\Controllers\Tenant\V1\User;

use App\Http\Controllers\ApiController;
use App\Http\Requests\User\DeptRequest;
use App\Services\Repositories\User\DeptRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JoyceZ\LaravelLib\Helpers\ResultHelper;

class Dept extends ApiController
{
    public function index(Request $request, DeptRepo $deptRepo): JsonResponse
    {
        return $this->success($deptRepo->getLists($request->all()));

    }

    /**
     * 新增部门
     * @param DeptRequest $request
     * @param DeptRepo $deptRepo
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function store(DeptRequest $request, DeptRepo $deptRepo): JsonResponse
    {
        $ret = $deptRepo->addDept($request->all());
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 更新部门
     * @param int $deptId
     * @param DeptRequest $request
     * @param DeptRepo $deptRepo
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function update(int $deptId, DeptRequest $request, DeptRepo $deptRepo): JsonResponse
    {
        $ret = $deptRepo->updateDept($deptId, $request->all());
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 删除
     * @param int $deptId
     * @param DeptRepo $deptRepo
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function destroy(int $deptId, DeptRepo $deptRepo): JsonResponse
    {
        $ret = $deptRepo->deleteDept($deptId);
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 更新某字段
     * @param DeptRequest $request
     * @param int $deptId
     * @param DeptRepo $deptRepo
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function modifyFiled(DeptRequest $request, int $deptId, DeptRepo $deptRepo): JsonResponse
    {
        if ($deptId <= 0) {
            return $this->badSuccessRequest('缺少必要的参数');
        }
        $fieldName = (string)$request->post('field_name');
        $fieldValue = $request->post('field_value');
        $ret = $deptRepo->updateSomeField($deptId, $fieldName, $fieldValue);
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }
}
