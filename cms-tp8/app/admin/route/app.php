<?php
use think\facade\Route;

// 无需登录的接口
Route::group('user', function () {
    Route::post('login', 'user/login');
    Route::get('captcha', 'user/captcha');
    Route::post('resetpwd', 'user/resetpwd');
});
Route::group('sms', function () {
    Route::post('pwd', 'sms/pwd');
});

// 需要登录的接口
Route::group(function () {
    Route::group('user',function(){
        Route::get('userinfo', 'user/userinfo');
        Route::post('logout', 'user/logout');
    });

    Route::group('dashboard', function () {
        Route::get('datas', 'dashboard/datas');
        Route::get('contentdatas', 'dashboard/contentdatas');
        Route::get('weekdatas', 'dashboard/weekdatas');
    });

    Route::group(function () {
        Route::group('cate',function(){
            Route::post('list', 'category/list');
            Route::post('add', 'category/add');
            Route::post('edit', 'category/edit');
            Route::post('del', 'category/del');
            Route::get('pidlist', 'category/pidlist');
        });

        Route::group('adminuser', function () {
            Route::post('list', 'admin/list');
            Route::post('add', 'admin/add');
            Route::post('edit', 'admin/edit');
            Route::post('del', 'admin/del');
        });
        Route::group('content', function () {
            Route::post('list', 'content/list');
            Route::post('add', 'content/add');
            Route::post('edit', 'content/edit');
            Route::post('del', 'content/del');

            Route::post('changestatus', 'content/changestatus');
            Route::post('changeaudit', 'content/changeaudit');
            
            Route::get('getcontent', 'content/getcontent');
        });

        Route::group('site', function () {
            Route::get('getinfo', 'site/getinfo');
            Route::post('save', 'site/save');
        });

        Route::group('system', function () {
            Route::post('files/list', 'files/list');
            Route::post('files/del', 'files/del');
            Route::post('adminlog/list', 'adminlog/list');
            Route::post('adminlog/del', 'adminlog/del');
        });

    })->middleware([\app\admin\middleware\Checkrole::class]);
    
    Route::group('loginlog', function () {
        Route::post('list', 'loginlog/list');
        Route::post('del', 'loginlog/del');
    });
    

    Route::group('upload', function () {
        Route::post('file', 'upload/file');
        Route::post('files', 'upload/files');
    });
    
    Route::group('personal', function () {
        Route::post('saveinfo', 'personal/saveinfo');
        Route::post('resetpwd', 'personal/resetpwd');
        Route::post('bindphone', 'personal/bindphone');
    });

    Route::group('sms', function () {
        Route::post('bindphone', 'sms/bindphone');
    });

    Route::group('role', function () {
        Route::get('getrulelistbyid', 'role/getrulelistbyid');
        Route::post('list', 'role/list');
        Route::post('add', 'role/add');
        Route::post('edit', 'role/edit');
        Route::post('del', 'role/del');
        Route::get('getrulelist', 'role/getrulelist');
    });
})->middleware([\app\admin\middleware\Checkuser::class]);
