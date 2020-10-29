<?php

/**
 * web.php
 *
 * @package imlooke\installer
 * @author lwx12525 <lwx12525@qq.com>
 */

Route::group([
    'prefix' => 'install',
    'as' => 'Installer::',
    'namespace' => 'Imlooke\Installer\Controllers',
    'middleware' => ['web', 'install'],
], function () {
    Route::get('/', [
        'as' => 'welcome',
        'uses' => 'WelcomeController@welcome',
    ]);
});

Route::group([
    'prefix' => 'install',
    'as' => 'Installer::',
    'namespace' => 'Imlooke\Installer\Controllers',
    'middleware' => ['api', 'install'],
], function () {
    Route::get('/requirements', [
        'as' => 'requirements',
        'uses' => 'RequirementsController@requirements',
    ]);

    Route::get('/permissions', [
        'as' => 'permissions',
        'uses' => 'PermissionsController@permissions',
    ]);

    Route::post('/environment', [
        'as' => 'environment',
        'uses' => 'EnvironmentController@environment',
    ]);
});
