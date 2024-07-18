<?php

namespace Module\Tenant\Http\Requests\User;

use LanDao\LaravelCore\Validation\BaseRequest;

/**
 * 部门表单校验 Request
 *
 * Class PostRequest
 * @package Module\Tenant\Http\Requests\User
 */
class PostRequest extends BaseRequest
{

    public function getRulesByStore(): array
    {
        return [
            'post_name' => 'required|max:150',
            'remark' => 'max:250',
            'is_enable' => 'required|boolean'
        ];
    }

    public function getRuleByUpdate(): array
    {
        return [
            'post_name' => 'required|max:150',
            'remark' => 'max:250',
            'is_enable' => 'required|boolean'
        ];
    }

    public function getRulesByModifyFiled():array
    {
        return [
            'dept_id' => 'required|numeric|min:0|not_in:0',
            'field_name' => 'required',
            'field_value' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'dept_name.required' => '请输入部门名',
            'dept_name.max' => '部门名字数超过限制',
            'parent_id.required' => '缺少上级部门',
            'parent_id.numeric' => '上级部门值有误',
            'remark.max' => '部门备注字数超过了限制',
            'is_enable.required' => '缺少启用字段',
            'is_enable.boolean' => '是否启用值有误',
            'dept_id.min' => '角色格式有误',
            'dept_id.not_in' => '角色格式有误',
            'field_name.required' => '缺少字段名',
            'field_value.required' => '缺少字段值',
        ];
    }


}
