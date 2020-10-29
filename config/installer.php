<?php

/**
 * installer.php
 *
 * @package imlooke\installer
 * @author lwx12525 <lwx12525@qq.com>
 */

return [
    /**
     * installed 文件路径
     */
    'installed_file_path' => storage_path('installed'),

    /**
     * 服务器端环境要求
     */
    'requirements' => [
        'min_php_version' => '7.3.0',
        'php' => [
            'openssl',
            'pdo',
            'mbstring',
            'tokenizer',
            'JSON',
            'cURL',
            'fileinfo',
            'gd',
        ],
        'apache' => [
            'mod_rewrite',
        ],
    ],

    /**
     * 文件夹权限
     */
    'permissions' => [
        'bootstrap/cache/'       => '775',
        'storage/'               => '775',
        'storage/app/public/'    => '775',
        'storage/app/backup/'    => '775',
        'storage/framework/'     => '775',
        'storage/logs/'          => '775',
    ],

    /**
     * 环境变量表单字段名称以及验证规则
     */
    'environment_form' => [
        'rules' => [
            'app_name'       => 'required|string|max:50',
            'app_url'        => 'required|url',
            'db_host'        => 'required|string|max:50',
            'db_port'        => 'required|numeric',
            'db_database'    => 'required|string|max:50',
            'db_username'    => 'required|string|max:50',
            'db_password'    => 'required|string|max:50',
            'db_prefix'      => 'required|string|max:50',
            'admin_username' => 'required|string|max:60',
            'admin_password' => 'required|string|max:60|min:6',
            'admin_email'    => 'nullable|string|max:60|email',
        ],
        'attributes' => [
            'app_name'       => '名称',
            'app_url'        => '网址',
            'db_host'        => '数据库主机',
            'db_port'        => '数据库端口号',
            'db_database'    => '数据库名称',
            'db_username'    => '数据库用户名',
            'db_password'    => '数据库密码',
            'db_prefix'      => '表前缀',
            'admin_username' => '管理员用户名',
            'admin_password' => '管理员密码',
            'admin_email'    => '管理员邮箱',
        ],
    ],

    /**
     * 迁移文件目录
     */
    'migration_paths' => [
        'database/migrations',
    ],

    /**
     * 填充文件类名
     */
    'seed_classes' => [
        'DatabaseSeeder',
    ],
];
