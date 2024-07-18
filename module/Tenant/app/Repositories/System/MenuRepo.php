<?php
declare(strict_types=1);

namespace Module\Tenant\Repositories\System;

use Illuminate\Database\QueryException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use LanDao\LaravelCore\Helpers\ResultHelper;
use LanDao\LaravelCore\Helpers\TreeHelper;
use LanDao\LaravelCore\Repositories\BaseRepository;
use Module\Tenant\Enums\Common\GlobalCacheKeyEnum;
use Module\Tenant\Enums\System\MenuTypeEnum;
use Module\Tenant\Models\System\MenuModel;

/**
 * 权限菜单 Repository 接口实现
 *
 * @author joyecZhang <https://qilindao.github.io/docs/backend/>
 *
 * Class MenuRepo
 * @package Module\Tenant\Repositories\System
 */
class MenuRepo extends BaseRepository
{

    /**
     * @return string
     */
    public function model()
    {
        return MenuModel::class;
    }

    /**
     * 需要展示的字段
     * @var array
     */
    const MENU_COLUMNS = [
        'menu_id',
        'parent_id',
        'name',
        'title',
        'icon',
        'type',
        'redirect',
        'path',
        'component',
        'auth_code',
        'order_no',
        'keep_alive',
        'hidden'
    ];


    /**
     * 组装前端需要的菜单数据格式
     * @param array $menuList
     * @return array
     */
    private function buildMenu(array $menuList): array
    {
        $list = [];
        foreach ($menuList as $item) {
            $meta = [
                'title' => $item['title'],
                'icon' => $item['icon'],
                'keepAlive' => $item['keep_alive'],
                'orderNo' => $item['order_no'],
                'hidden' => $item['hidden'],
            ];
            //添加新的键值，移除不需要的键值
            $list[] = Arr::except(Arr::add($item, 'meta', $meta), ['title', 'icon', 'keep_alive', 'order_no', 'hidden']);
        }
        return $list;
    }

    /**
     * 获取所有菜单权限，并缓存
     * @return array
     */
    public function getAllList(): array
    {
        $cacheKey = GlobalCacheKeyEnum::LAN_DAO_MENU->value;
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        $menuList = $this->model->orderBy('order_no', 'ASC')->get(self::MENU_COLUMNS)->toArray();
        if ($menuList) {
            Cache::put($cacheKey, $menuList);
        }
        return $menuList;
    }

    /**
     * 获取菜单和权限
     * @return array
     */
    public function getMenuLists(): array
    {
        $tenant = tenancy()->tenant;
        if ($tenant->is_default) {
            return $this->buildMenu($this->getAllList());
        }
        $menuIds = array_unique($tenant->menus);
//        $menuListRet = $this->model->where(function ($query) use ($menuIds) {
//            if (count($menuIds) > 0) {
//                $query->whereIn('menu_id', $menuIds);
//            }
//        })->orderBy('order_no', 'ASC')->get(self::MENU_COLUMNS)->toArray();
        //过滤没拥有的权限
//        $filteredMenu = Arr::where($this->getAllList(), function (array $item, int $key) use ($menuIds) {
//            return in_array($item['menu_id'], $menuIds);
//        });
        $filteredMenu = Arr::where($this->getAllList(), fn(array $item, int $key): bool => in_array($item['menu_id'], $menuIds));
        return $this->buildMenu($filteredMenu);
    }

    /**
     * 获取详情
     * @param int $menuId
     * @return array
     */
    public function getMenuInfo(int $menuId): array
    {
        return Arr::first($this->getAllList(), fn(array $menu) => $menu['menu_id'] == $menuId);
    }

    /**
     * 获取角色对应 菜单和权限
     * @param array $menuIdsList 菜单IDs
     * @return array
     */
    public function generatePermission(array $menuIdsList = []): array
    {
        $menuList = $this->getMenuLists($menuIdsList);
        $menus = $power = [];

        foreach ($menuList as $item) {
            //目录和菜单
            if (in_array($item['type'], [MenuTypeEnum::MENU_TYPE_CATALOG->value, MenuTypeEnum::MENU_TYPE_MENU->value])) {
                $menus[] = $item;
                continue;
            } elseif ($item['type'] == MenuTypeEnum::MENU_TYPE_PERMISSION->value) {//按钮权限
                $power[] = $item['auth_code'];
                continue;
            }
        }
        //将菜单打成树形结构
        $menus = TreeHelper::listToTree($menus, 0, 'menu_id', 'parent_id');
        return compact('menus', 'power');
    }

    /**
     * 新增菜单权限
     * @param array $input
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    public function addMenu(array $input): array
    {
        $input['parent_id'] = trim((string)$input['parent_id']) == '' ? 0 : $input['parent_id'];
        $menu = $this->existsWhere(['name' => $input['name']]);
        if ($menu) {
            return ResultHelper::error('节点路由名已存在');
        }
        $this->transaction();
        try {
            $input['component'] = $input['type'] == MenuTypeEnum::MENU_TYPE_PERMISSION->value ? "" : $input['component'];
            $input['keep_alive'] = $input['type'] == MenuTypeEnum::MENU_TYPE_PERMISSION->value ? false : $input['keep_alive'];
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
     * 根据id更新菜单权限
     * @param int $menuId
     * @param array $input
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    public function updateMenu(int $menuId, array $input): array
    {
        $this->transaction();
        try {
            $input['component'] = $input['type'] == MenuTypeEnum::MENU_TYPE_PERMISSION->value ? "" : $input['component'];
            $input['keep_alive'] = $input['type'] == MenuTypeEnum::MENU_TYPE_PERMISSION->value ? false : $input['keep_alive'];
            if ($this->updateById($input, $menuId)) {
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
     * 删除菜单权限
     * @param int $menuId
     * @return array
     */
    public function delMenu(int $menuId): array
    {
        $menu = $this->getInfoById($menuId);
        if (!$menu) {
            return ResultHelper::error('菜单不存在');
        }
        $this->transaction();
        try {
            if ($menu->delete()) {
                $menu->roles()->detach($menuId);
                $this->commit();
                return ResultHelper::success('删除成功');
            }
            $this->rollBack();
            return ResultHelper::error('更新失败');
        } catch (QueryException $exception) {
            $this->rollBack();
            return ResultHelper::error($exception->getMessage());
        }
    }

    /**
     * 根据id，更新某字段值
     * @param int $menuId
     * @param string $fieldName
     * @param mixed $fieldValue
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \LanDao\LaravelCore\Exceptions\RepositoryException
     */
    public function updateSomeField(int $menuId, string $fieldName, Mixed $fieldValue): array
    {
        $this->transaction();
        try {
            if ($this->updateFieldById($menuId, $fieldName, $fieldValue)) {
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
