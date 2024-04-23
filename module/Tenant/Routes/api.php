<?php

use Illuminate\Support\Facades\Route;
use Module\Tenant\Http\Controllers\V1\Passport;
use Module\Tenant\Http\Controllers\V1\System\Menu;
use Module\Tenant\Http\Controllers\V1\User\Role;

Route::prefix('v1')
    ->namespace('V1')
    ->middleware(['api.case.converter'])
    ->group(function ($router) {
        $router->get('/passport/captcha', [Passport::class, 'captcha'])->name('passport:captcha');//图片验证码
        $router->post('/passport/login', [Passport::class, 'login'])->name('passport:login');//登录
        $router->group([
            'middleware' => ['auth:sanctum', 'auth.tenant', 'userOperate.log'],
        ], function ($router) {
            $router->post('/passport/logout', [Passport::class, 'logout'])->name('passport:logout');//退出登录

            //菜单权限
            $router->get('/menu', [Menu::class, 'index'])->name('menu:index');//菜单权限列表
            $router->get('/menu/read/{id}', [Menu::class, 'read'])->whereNumber('id')->name('menu:read');//详情
            $router->post('/menu/store', [Menu::class, 'store'])->name('menu:store');//提交菜单数据
            $router->put('/menu/update/{id}', [Menu::class, 'update'])->whereNumber('id')->name('menu:update');//更新菜单
            $router->delete('/menu/delete/{id}', [Menu::class, 'destroy'])->whereNumber('id')->name('menu:destroy');//删除菜单
            $router->get('/menu/power', [Menu::class, 'power'])->name('menu:power');//获取route别名权限
            $router->post('/menu/modify/{id}', [Menu::class, 'modifyFiled'])->whereNumber('id')->name('menu:modifyFiled');//快捷修改

            //角色
            $router->get('/role', [Role::class, 'index'])->name('role:index');//菜单权限列表
            $router->get('/role/read/{id}', [Role::class, 'read'])->name('role:read');//详情
            $router->get('/role/list', [Role::class, 'lists'])->name('role:list');//列表
            $router->post('/role/store', [Role::class, 'store'])->name('role:store');//提交菜单数据
            $router->put('/role/update/{id}', [Role::class, 'update'])->name('role:update');//更新菜单
            $router->delete('/role/delete/{id}', [Role::class, 'destroy'])->name('role:destroy');//删除菜单
            $router->post('/role/modify/{id}', [Role::class, 'modifyFiled'])->where('id', '[0-9]+')->name('role:modifyFiled');//快捷修改
            $router->post('/role/update/auth/{id}', [Role::class, 'updateRoleAuth'])->where('id', '[0-9]+')->name('role:updateRoleAuth');//更新权限
        });


    });
Route::fallback(function (\Illuminate\Http\Request $request) {
    return response()->json(['status' => 'error', 'code' => 404, 'message' => $request->url() . ' Not Found!'], 404);
});
