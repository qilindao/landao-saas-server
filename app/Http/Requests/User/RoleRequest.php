<?php

namespace App\Http\Requests\User;

use JoyceZ\LaravelLib\Validation\BaseRequest;

class RoleRequest extends BaseRequest
{
    public function getRulesByStore(): array
    {
        return [
            'role_name' => 'required|max:150',
            'remark' => 'max:250',
            'is_enable' => 'required|boolean'
        ];
    }

    public function getRuleByUpdate(): array
    {
        return [
            'role_name' => 'required|max:150',
            'remark' => 'max:250',
            'is_enable' => 'required|boolean'
        ];
    }

    public function getRulesByUpdateRoleAuth(): array
    {
        return [
            'menus' => 'required|array|min:1'
        ];
    }

    public function getRulesByModifyFiled(): array
    {
        return [
//            'role_id' => 'required|numeric|min:0|not_in:0',
            'field_name' => 'required',
            'field_value' => 'required'
        ];
    }


    public function messages(): array
    {
        return [
            'role_name.required' => '请输入角色名',
            'role_name.max' => '角色名字数超过限制',
            'remark.max' => '角色备注字数超过了限制',
            'is_enable.required' => '缺少启用字段',
            'is_enable.boolean' => '是否启用值有误',
            'menus.required' => '请选中功能权限',
            'menus.array' => '功能权限格式错误',
            'menus.min' => '至少选中一个功能权限',
            'role_id.min' => '角色格式有误',
            'role_id.not_in' => '角色格式有误',
            'field_name.required' => '缺少字段名',
            'field_value.required' => '缺少字段值',
        ];
    }
}
