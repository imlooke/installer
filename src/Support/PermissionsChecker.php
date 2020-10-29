<?php

namespace Imlooke\Installer\Support;

/**
 * PermissionsChecker
 *
 * @package imlooke\installer
 * @author lwx12525 <lwx12525@qq.com>
 */
class PermissionsChecker
{
    /**
     * 权限检查
     *
     * @return array
     */
    public function check(): array
    {
        $response = [];
        $permissions = config('installer.permissions');

        foreach ($permissions as $folder => $permission) {
            $response[$folder] = [
                'permission' => $permission,
                'current_permission' => $this->getFolderPermission($folder),
                'supported' => true,
            ];

            if ($response[$folder]['current_permission'] < $permission) {
                $response[$folder]['supported'] = false;
                $response['errors'] = true;
            }
        }

        return $response;
    }

    /**
     * 获取文件夹权限
     *
     * @param  string $folder
     * @return string
     */
    protected function getFolderPermission(string $folder): string
    {
        return substr(sprintf('%o', fileperms(base_path($folder))), -4);
    }
}
