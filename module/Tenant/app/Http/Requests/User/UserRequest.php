<?php

namespace Module\Tenant\Http\Requests\User;

use LanDao\LaravelCore\Validation\BaseRequest;

/**
 * 请说明具体哪块业务的 Request
 *
 * Class UserRequest
 * @package Module\Tenant\Http\Requests\User
 */
class UserRequest extends BaseRequest
{

    public function getRulesByStore(): array
    {
        return [
            'post_name' => 'required|max:150',
            'remark' => 'max:250',
            'password' => ['required', 'between:6,20', function ($attribute, $value, $fail) {
                if ($value == '123456' || $value == 'admin') {
                    $fail("参数 {$attribute} 不符合要求.");
                }
            }]
        ];
    }

    /**
     * 统一定义验证规则的自定义错误消息。
     * @return array
     */
    public function messages(): array
    {
        return [

        ];
    }


}
