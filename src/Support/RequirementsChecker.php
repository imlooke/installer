<?php

namespace Imlooke\Installer\Support;

/**
 * RequirementsChecker
 *
 * @package imlooke\installer
 * @author lwx12525 <lwx12525@qq.com>
 */
class RequirementsChecker
{
    /**
     * 环境要求检查
     *
     * @return array
     */
    public function check(): array
    {
        $response = [];
        $requirements = config('installer.requirements');

        foreach ($requirements as $key => $requirement) {
            switch ($key) {
                case 'min_php_version':
                    $response[$key] = [
                        'min_version' => $requirements[$key],
                        'current_version' => phpversion(),
                        'supported' => true,
                    ];

                    // 当前 PHP 版本要高于最小 PHP 版本
                    if (version_compare(phpversion(), $requirements[$key], '<')) {
                        $response[$key]['supported'] = false;
                        $response['errors'] = true;
                    }
                    break;
                case 'php':
                    foreach ($requirement as $item) {
                        $response[$key][$item] = true;

                        // extension_loaded 检查一个扩展是否已经加载
                        if (!extension_loaded($item)) {
                            $response[$key][$item] = false;
                            $response['errors'] = true;
                        }
                    }
                    break;
                case 'apache':
                    // apache_get_modules 获得已加载的 Apache 模块列表
                    // php 通过 apache 模块方式安装，该函数才有效
                    if (function_exists('apache_get_modules')) {
                        foreach ($requirement as $item) {
                            $response[$key][$item] = true;

                            if (!in_array($item, apache_get_modules())) {
                                $response[$key][$item] = false;
                                $response['errors'] = true;
                            }
                        }
                    }
                    break;
                default:
                    break;
            }
        }

        return $response;
    }
}
