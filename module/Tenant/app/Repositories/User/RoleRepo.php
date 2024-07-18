<?php
declare(strict_types=1);

namespace Module\Tenant\Repositories\User;

use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use LanDao\LaravelCore\Helpers\FiltersHelper;
use LanDao\LaravelCore\Helpers\ResultHelper;
use LanDao\LaravelCore\Repositories\BaseRepository;
use Module\Tenant\Models\User\RoleModel;

/**
 * 用户角色 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class RoleRepo
 * @package Module\Tenant\Repositories\User
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
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    public function addRole(array $input): array
    {
        $this->transaction();
        try {
            $input['role_name'] = FiltersHelper::filterXSS(trim($input['role_name']));
            $input['remark'] = isset($input['remark']) ? FiltersHelper::filterXSS(trim($input['remark'])) : "";
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
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    public function updateRole(int $roleId, array $input): array
    {
        $this->transaction();
        try {
            $input['role_name'] = FiltersHelper::filterXSS(trim($input['role_name']));
            $input['remark'] = isset($input['remark']) ? FiltersHelper::filterXSS(trim($input['remark'])) : "";
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
     * 更新角色权限
     * @param int $roleId
     * @param array $menus
     * @return array
     */
    public function updateRoleAuth(int $roleId, array $menus): array
    {
        $role = $this->getInfoById($roleId);
        if (!$role) {
            return ResultHelper::error('角色不存在');
        }
        $this->transaction();
        try {
            $role->menus()->sync(array_filter(array_unique($menus)));
            $this->commit();
            return ResultHelper::success('更新成功');
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
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
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
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
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
