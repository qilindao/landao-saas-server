<?php

namespace Module\Tenant\Http\Requests\System;

use LanDao\LaravelCore\Validation\BaseRequest;

/**
 * 请说明具体哪块业务的 Request
 *
 * Class MenuRequest
 * @package Module\Tenant\Http\Requests\System
 */
class MenuRequest extends BaseRequest
{

    /**
     *  定义针对 Controller->store( )的验证规则
     * @return array
     */
    public function getRulesByStore(): array
    {
        return [

        ];
    }

    /**
     *  定义针对 Controller->update( )的验证规则
     * @return array
     */
    public function getRulesByUpdate(): array
    {
        return [

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
