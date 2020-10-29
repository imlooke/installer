<?php

namespace Imlooke\Installer\Controllers;

use Illuminate\Routing\Controller;
use Imlooke\Installer\Support\PermissionsChecker;

/**
 * PermissionsController
 *
 * @package imlooke\installer
 * @author lwx12525 <lwx12525@qq.com>
 */
class PermissionsController extends Controller
{
    /**
     * 权限检查
     *
     * @param  PermissionsChecker $permissionsChecker
     * @return View
     */
    public function permissions(PermissionsChecker $permissionsChecker)
    {
        $response = $permissionsChecker->check();

        return $response;
    }
}
