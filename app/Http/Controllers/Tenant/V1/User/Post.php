<?php

namespace App\Http\Controllers\Tenant\V1\User;

use App\Http\Controllers\ApiController;
use App\Http\Requests\User\PostRequest;
use App\Services\Repositories\User\PostRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JoyceZ\LaravelLib\Helpers\ResultHelper;

class Post extends ApiController
{
    public function index(Request $request, PostRepo $postRepo): JsonResponse
    {
        $ret = $postRepo->getLists($request->all());
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
     * 新增
     * @param PostRequest $request
     * @param PostRepo $roleRepo
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function store(PostRequest $request, PostRepo $postRepo): JsonResponse
    {
        $ret = $postRepo->addPost($request->all());
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 更新
     * @param int $postId
     * @param PostRequest $request
     * @param PostRepo $postRepo
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function update(int $postId, PostRequest $request, PostRepo $postRepo): JsonResponse
    {
        $ret = $postRepo->updatePost($postId, $request->all());
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 删除
     * @param int $postId
     * @param PostRepo $postRepo
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function destroy(int $postId, PostRepo $postRepo): JsonResponse
    {
        $ret = $postRepo->deletePost($postId);
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 更新某字段
     * @param PostRequest $request
     * @param int $postId
     * @param PostRepo $postRepo
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function modifyFiled(PostRequest $request, int $postId, PostRepo $postRepo): JsonResponse
    {
        if ($postId <= 0) {
            return $this->badSuccessRequest('缺少必要的参数');
        }
        $fieldName = (string)$request->post('field_name');
        $fieldValue = $request->post('field_value');
        $ret = $postRepo->updateSomeField($postId, $fieldName, $fieldValue);
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }
}
