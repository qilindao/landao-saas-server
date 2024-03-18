<?php
declare(strict_types=1);

namespace App\Services\Repositories\User;

use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use JoyceZ\LaravelLib\Helpers\FiltersHelper;
use JoyceZ\LaravelLib\Helpers\ResultHelper;
use JoyceZ\LaravelLib\Repositories\BaseRepository;
use App\Services\Models\User\RoleModel;

/**
 * 请说明具体哪块业务的 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class RoleRepo
 * @package App\Services\Repositories\User;
 */
class RoleRepo extends BaseRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return RoleModel::class;
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
                $query->where('role_name', 'like', '%' . $input['search_text'] . '%');
            }
        })
            ->with('menus:menu_id')
            ->orderBy('updated_at', 'desc')
            ->paginate(isset($params['page_size']) ? $params['page_size'] : config('landao.paginate.page_size'));
        $roles = $lists->toArray();
        foreach ($roles['data'] as $key => $role) {
            $roles['data'][$key]['menus'] = Arr::flatten($role['menus']);
        }
        return $roles;
    }

    /**
     * 新增角色
     * @param array $input
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function addRole(array $input): array
    {
        $this->transaction();
        try {
            $input['role_name'] = FiltersHelper::filterXSS(trim($input['role_name']));
            $input['remark'] = isset($input['remark']) ? FiltersHelper::filterXSS(trim($input['remark'])) : "";
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
     * 更新角色
     * @param int $roleId
     * @param array $input
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function updateRole(int $roleId, array $input): array
    {
        $this->transaction();
        try {
            $input['role_name'] = FiltersHelper::filterXSS(trim($input['role_name']));
            $input['remark'] = isset($input['remark']) ? FiltersHelper::filterXSS(trim($input['remark'])) : "";
            $input['updated_by'] = $input['curren_user_id'];
            //更新
            if ($this->updateByWhere([
                'role_id' => $roleId,
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
    public function deleteRole(int $roleId): array
    {
        $this->transaction();
        try {
            //更新
            if ($this->deleteWhere([
                'role_id' => $roleId,
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
     * @param int $roleId
     * @param string $fieldName
     * @param mixed $fieldValue
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \JoyceZ\LaravelLib\Exceptions\RepositoryException
     */
    public function updateSomeField(int $roleId, string $fieldName, Mixed $fieldValue): array
    {
        $this->transaction();
        try {
            if ($this->updateFieldById($roleId, $fieldName, $fieldValue)) {
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
