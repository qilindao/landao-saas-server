<?php
declare(strict_types=1);

namespace App\Services\Repositories\Tenant;

use Illuminate\Database\QueryException;
use JoyceZ\LaravelLib\Helpers\FiltersHelper;
use JoyceZ\LaravelLib\Helpers\ResultHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;
use App\Services\Models\Tenant\AlbumModel;

/**
 * 请说明具体哪块业务的 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class AlbumRepo
 * @package App\Services\Repositories\Tenant;
 */
class AlbumRepo extends BaseRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return AlbumModel::class;
    }

    /**
     * 新增
     * @param array $input
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function addAlbum(array $input): array
    {
        $this->transaction();
        try {
            $input['album_name'] = FiltersHelper::filterXSS(trim($input['album_name']));
            $input['album_sort'] = intval($input['album_sort']);
            $input['parent_id'] = intval($input['parent_id']);
            $input['created_by'] = $input['curren_user_id'];
            if ($this->create($input)) {
                $this->commit();
                return ResultHelper::success('新增成功');
            }
            $this->rollBack();
            return ResultHelper::error('新增失败');
        } catch (QueryException $exception) {
            $this->rollBack();
            return ResultHelper::error($exception->getMessage());
        }
    }

    /**
     * 更新
     * @param int $albumId
     * @param array $input
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function updateAlbum(int $albumId, array $input): array
    {
        $this->transaction();
        try {
            $input['album_name'] = FiltersHelper::filterXSS(trim($input['album_name']));
            $input['album_sort'] = intval($input['album_sort']);
            $input['parent_id'] = intval($input['parent_id']);
            $input['updated_by'] = $input['curren_user_id'];
            //更新
            if ($this->updateByWhere([
                'album_id' => $albumId,
            ], $input)) {
                $this->commit();
                return ResultHelper::success('更新成功');
            }
            $this->rollBack();
            return ResultHelper::error('更新失败');
        } catch (QueryException $exception) {
            $this->rollBack();
            return ResultHelper::error($exception->getMessage());
        }
    }

    /**
     * 删除相册
     * @param int $albumId
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function deleteAlbum(int $albumId): array
    {
        $this->transaction();
        try {
            //更新
            if ($this->deleteWhere([
                'album_id' => $albumId,
            ])) {
                $albumFileRepo = $this->app->make(AlbumFileRepo::class);
                if ($albumFileRepo->count(['album_id' => $albumId], 'file_id') > 0) {
                    $default = $this->where(['is_default' => 1])->first(['album_id']);
                    $albumFileRepo->updateByWhere(['album_id' => $albumId], ['album_id' => $default->album_id]);
                }
                $this->commit();
                return ResultHelper::success('删除成功');
            }
            $this->rollBack();
            return ResultHelper::error('删除失败');
        } catch (QueryException $exception) {
            $this->rollBack();
            return ResultHelper::error($exception->getMessage());
        }
    }
}
