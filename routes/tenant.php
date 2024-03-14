<?php

use Illuminate\Support\Facades\Route;

Route::name('tenant:')
    ->prefix('v1')
    ->namespace('Tenant\\V1')
    ->middleware(['api.case.converter'])
    ->group(function ($router) {
        $router->get('/passport/captcha', 'Passport@captcha')->name('passport:captcha');//图片验证码
        $router->post('/passport/login', 'Passport@login')->name('passport:login');//登录
        $router->group([
            'middleware' => ['auth:sanctum', 'auth.tenant', 'userOperate.log'],
        ], function ($router) {
            $router->post('/passport/logout', 'Passport@logout')->name('passport:logout');//退出登录

            //菜单权限
            $router->get('/menu', 'System\Menu@index')->name('menu:index');//菜单权限列表
            $router->get('/menu/read/{id}', 'System\Menu@read')->whereNumber('id')->name('menu:read');//详情
            $router->post('/menu/store', 'System\Menu@store')->name('menu:store');//提交菜单数据
            $router->put('/menu/update/{id}', 'System\Menu@update')->whereNumber('id')->name('menu:update');//更新菜单
            $router->delete('/menu/delete/{id}', 'System\Menu@destroy')->whereNumber('id')->name('menu:destroy');//删除菜单
            $router->get('/menu/power', 'System\Menu@power')->name('menu:power');//获取route别名权限
            $router->post('/menu/modify/{id}', 'System\Menu@modifyFiled')->whereNumber('id')->name('menu:modifyFiled');//快捷修改

            //角色
            $router->get('/role', 'User\Role@index')->name('role:index');//菜单权限列表
            $router->get('/role/read/{id}', 'User\Role@read')->name('role:read');//详情
            $router->get('/role/list', 'User\Role@lists')->name('role:list');//列表
            $router->post('/role/store', 'User\Role@store')->name('role:store');//提交菜单数据
            $router->put('/role/update/{id}', 'User\Role@update')->name('role:update');//更新菜单
            $router->delete('/role/delete/{id}', 'User\Role@destroy')->name('role:destroy');//删除菜单
            $router->post('/role/modify/{id}', 'User\Role@modifyFiled')->where('id', '[0-9]+')->name('role:modifyFiled');//快捷修改
            $router->post('/role/update/auth/{id}', 'User\Role@updateRoleAuth')->where('id', '[0-9]+')->name('role:updateRoleAuth');//更新权限
        });

    });

