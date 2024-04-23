<?php

namespace Module\Tenant\Http\Requests\Routine;

use JoyceZ\LaravelLib\Validation\BaseRequest;

class AlbumRequest extends BaseRequest
{

    public function getRulesByStore(): array
    {
        return [
            'album_name' => 'required|max:150',
//            'remark' => 'max:250',
            'parent_id' => 'required|numeric',
            'album_sort' => 'required|numeric'
        ];
    }

    public function getRuleByUpdate(): array
    {
        return [
            'album_name' => 'required|max:150',
//            'remark' => 'max:250',
            'parent_id' => 'required|numeric',
            'album_sort' => 'required|numeric'
        ];
    }

    public function getRuleByUpload(): array
    {
        return [
            'album_id' => 'required|numeric',
            'file'=>'required|image'
        ];
    }

    public function messages(): array
    {
        return [
            'album_name.required' => '请输入相册名',
            'album_name.max' => '相册名字数超过限制',
            'parent_id.required' => '缺少上级目录',
            'parent_id.numeric' => '上级目录值有误',
            'album_id.required' => '缺少相册标识',
            'album_id.numeric' => '想啊册标识值有误',
            'file.required' => '请上传图片',
            'file.image' => '图片格式有误',
        ];
    }

}
