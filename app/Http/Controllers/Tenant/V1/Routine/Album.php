<?php

namespace App\Http\Controllers\Tenant\V1\Routine;

use App\Http\Controllers\ApiController;
use App\Http\Requests\Routine\AlbumRequest;
use App\Services\Repositories\Tenant\AlbumFileRepo;
use App\Services\Repositories\Tenant\AlbumRepo;
use Illuminate\Http\JsonResponse;
use JoyceZ\LaravelLib\Helpers\ResultHelper;
use JoyceZ\LaravelLib\Helpers\TreeHelper;

class Album extends ApiController
{
    public function __construct(protected AlbumRepo $albumRepo)
    {

    }

    public function index(): JsonResponse
    {
        $lists = $this->albumRepo
            ->orderBy('created_at')
            ->all(['album_id', 'album_name', 'parent_id', 'album_sort', 'is_default'])
            ->toArray();
//        array_unshift($lists, ['album_id' => 0, 'album_name' => '全部文件', 'parent_id' => 0, 'album_sort' => 0, 'is_default' => true]);
        return $this->success(TreeHelper::listToTree($lists, 0, 'album_id', 'parent_id'));
    }

    /**
     * 新增
     * @param AlbumRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function store(AlbumRequest $request): JsonResponse
    {
        $ret = $this->albumRepo->addAlbum($request->all());
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 更新
     * @param int $albumId
     * @param AlbumRequest $request
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function update(int $albumId, AlbumRequest $request): JsonResponse
    {
        $ret = $this->albumRepo->updateAlbum($albumId, $request->all());
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 删除相册
     * @param int $albumId
     * @return JsonResponse
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function destroy(int $albumId): JsonResponse
    {
        $ret = $this->albumRepo->deleteAlbum($albumId);
        if ($ret['code'] == ResultHelper::CODE_SUCCESS) {
            return $this->success($ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }

    /**
     * 上传文件
     * @param AlbumRequest $request
     * @param AlbumFileRepo $albumFileRepo
     * @return JsonResponse
     */
    public function upload(AlbumRequest $request, AlbumFileRepo $albumFileRepo): JsonResponse
    {
        $ret = $albumFileRepo->doLocalUpload($request);
        if ($ret['code'] == 200) {
            return $this->success($ret['data'], $ret['message']);
        }
        return $this->badSuccessRequest($ret['message']);
    }
}
