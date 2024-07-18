<?php
declare(strict_types=1);

namespace Module\Tenant\Repositories\User;

use Illuminate\Database\QueryException;
use LanDao\LaravelCore\Helpers\FiltersHelper;
use LanDao\LaravelCore\Helpers\ResultHelper;
use LanDao\LaravelCore\Repositories\BaseRepository;
use Module\Tenant\Models\User\PostModel;

/**
 * 用户岗位 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class PostRepo
 * @package Module\Tenant\Repositories\User
 */
class PostRepo extends BaseRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return PostModel::class;
    }

    /**
     * 获取列表
     * @param array $input
     * @return array
     */
    public function getLists(array $input): array
    {
        $lists = $this->model->where(function ($query) use ($input) {
            if (isset($input['search_text']) && $input['search_text'] != '') {
                $query->where('post_name', 'like', '%' . $input['search_text'] . '%');
            }
        })
            ->orderBy('updated_at', 'desc')
            ->paginate(isset($params['page_size']) ? $params['page_size'] : config('landao.paginate.page_size'));
        return $lists->toArray();
    }

    /**
     * 新增
     * @param array $input
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    public function addPost(array $input): array
    {
        $this->transaction();
        try {
            $input['post_name'] = FiltersHelper::filterXSS(trim($input['post_name']));
            $input['remark'] = isset($input['remark']) ? FiltersHelper::filterXSS(trim($input['remark'])) : '';
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
     * @param int $postId
     * @param array $input
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    public function updatePost(int $postId, array $input): array
    {
        $this->transaction();
        try {
            $input['post_name'] = FiltersHelper::filterXSS(trim($input['post_name']));
            $input['remark'] = isset($input['remark']) ? FiltersHelper::filterXSS(trim($input['remark'])) : '';
            //更新
            if ($this->updateByWhere([
                'role_id' => $postId
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
     * 删除
     * @param int $postId
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    public function deletePost(int $postId): array
    {
        $this->transaction();
        try {
            //更新
            if ($this->deleteWhere([
                'post_id' => $postId
            ])) {
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
     * 更新某字段
     * @param int $postId
     * @param string $fieldName
     * @param mixed $fieldValue
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    public function updateSomeField(int $postId, string $fieldName, Mixed $fieldValue): array
    {
        $this->transaction();
        try {
            if ($this->updateByWhere([
                'post_id' => $postId
            ], [$fieldName => $fieldValue, 'updated_by' => now()->timestamp])) {
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
}
