<?php

namespace Imlooke\Installer\Support;

/**
 * InstalledFileManager
 *
 * @package imlooke\installer
 * @author lwx12525 <lwx12525@qq.com>
 */
class InstalledFileManager
{
    /**
     * 创建 installed 文件。
     *
     * @return int
     */
    public function create()
    {
        $installedFilePath = config('installer.installed_file_path');
        $date = date("Y/m/d h:i:s");

        if (!file_exists($installedFilePath)) {
            $content = 'Imlooke 安装成功，时间：' . $date . "\n";
            file_put_contents($installedFilePath, $content);
        } else {
            $content = 'Imlooke 更新成功，时间：' . $date . "\n";
            file_put_contents($installedFilePath, $content . PHP_EOL, FILE_APPEND | LOCK_EX);
        }

        return $content;
    }

    /**
     * 更新 installed 文件.
     *
     * @return int
     */
    public function update()
    {
        return $this->create();
    }
}
