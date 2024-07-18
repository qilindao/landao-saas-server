<?php

namespace Module\Tenant\Http\Controllers\V1\User;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use LanDao\LaravelCore\Attributes\Inject;
use LanDao\LaravelCore\Attributes\Router\Delete;
use LanDao\LaravelCore\Attributes\Router\Middleware;
use LanDao\LaravelCore\Attributes\Router\Post;
use LanDao\LaravelCore\Attributes\Router\Put;
use LanDao\LaravelCore\Attributes\Router\WhereNumber;
use LanDao\LaravelCore\Controllers\ApiController;
use LanDao\LaravelCore\Helpers\ResultHelper;
use Module\Tenant\Http\Requests\User\PostRequest;
use Module\Tenant\Repositories\User\PostRepo;

/**
 * 岗位
 */
#[Middleware(['auth:sanctum', 'auth.tenant', 'userOperate.log'])]
class PostController extends ApiController
{
    #[Inject]
    protected PostRepo $postRepo;

    /**
     * 分页列表
     * @param Request $request
     * @return JsonResponse
     */
    #[Get(uri: '/post', name: 'post.index')]
    public function index(Request $request): JsonResponse
    {
        $ret = $this->postRepo->getLists($request->all());
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
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    #[Post(uri: '/post/store', name: 'post.store')]
    public function store(PostRequest $request): JsonResponse
    {
        $ret = $this->postRepo->addPost($request->all());
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 更新
     * @param int $postId
     * @param PostRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    #[Put(uri: '/post/{postId}', name: 'post.update'), WhereNumber('postId')]
    public function update(int $postId, PostRequest $request): JsonResponse
    {
        $ret = $this->postRepo->updatePost($postId, $request->all());
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 删除
     * @param int $postId
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    #[Delete(uri: '/post/{postId}', name: 'post.destroy'), WhereNumber('postId')]
    public function destroy(int $postId): JsonResponse
    {
        $ret = $this->postRepo->deletePost($postId);
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 更新某字段
     * @param PostRequest $request
     * @param int $postId
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    #[Post(uri: '/post/modify/postId', name: 'post.modifyFiled'), WhereNumber('postId')]
    public function modifyFiled(PostRequest $request, int $postId): JsonResponse
    {
        if ($postId <= 0) {
            return $this->badSuccessRequest('缺少必要的参数');
        }
        $fieldName = (string)$request->post('field_name');
        $fieldValue = $request->post('field_value');
        $ret = $this->postRepo->updateSomeField($postId, $fieldName, $fieldValue);
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }
}
