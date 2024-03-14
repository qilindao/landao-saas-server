<?php

namespace App\Http\Requests\Passport;

use JoyceZ\LaravelLib\Validation\BaseRequest;

class LoginRequest extends BaseRequest
{
    public function getRulesByLogin(): array
    {
        return [
            'username' => 'required',
            'password' => 'required|min:8',
            'verify_code' => 'required|size:4',
            'captcha_uniq_id' => 'required'
        ];

    }

    public function messages(): array
    {
        return [
            'username.required' => '账号不能为空',
            'password.required' => '密码不能为空',
            'password.min' => '密码最少要输入8个字符',
            'verify_code.required' => '验证码不能为空',
            'verify_code.size' => '验证码位数错误',
            'captcha_uniq_id.required' => '非法操作验证码',
        ];
    }
}
