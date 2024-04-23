<?php
declare(strict_types=1);

namespace Module\Tenant\Repositories\User;

use Illuminate\Database\QueryException;
use JoyceZ\LaravelLib\Helpers\FiltersHelper;
use JoyceZ\LaravelLib\Helpers\ResultHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;
use Module\Tenant\Models\User\DeptModel;

/**
 * 请说明具体哪块业务的 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class DeptRepo
 * @package Module\Tenant\epositories\User;
 */
class DeptRepo extends BaseRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return DeptModel::class;
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
                $query->where('dept_name', 'like', '%' . $input['search_text'] . '%');
            }
        })
            ->orderBy('updated_at', 'desc')
            ->get();
        return $lists->toArray();
    }

    /**
     * 新增角色
     * @param array $input
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function addDept(array $input): array
    {
        $this->transaction();
        try {
            $input['dept_name'] = FiltersHelper::filterXSS(trim($input['dept_name']));
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
     * 更新部门
     * @param int $deptId
     * @param array $input
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function updateDept(int $deptId, array $input): array
    {
        $this->transaction();
        try {
            $input['dept_name'] = FiltersHelper::filterXSS(trim($input['dept_name']));
            //更新
            if ($this->updateByWhere([
                'dept_id' => $deptId
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
     * 删除角色
     * @param int $roleId
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function deleteDept(int $deptId): array
    {
        $this->transaction();
        try {
            //更新
            if ($this->deleteWhere([
                'dept_id' => $deptId
            ])) {
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

    /**
     * 更新某字段
     * @param int $deptId
     * @param string $fieldName
     * @param mixed $fieldValue
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function updateSomeField(int $deptId, string $fieldName, Mixed $fieldValue): array
    {
        $this->transaction();
        try {
            if ($this->updateByWhere([
                'dept_id' => $deptId,
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
