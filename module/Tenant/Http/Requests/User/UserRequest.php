<?php

namespace Module\Tenant\Http\Requests\User;

use JoyceZ\LaravelLib\Validation\BaseRequest;

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
}
