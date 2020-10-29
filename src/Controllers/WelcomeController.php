<?php

namespace Imlooke\Installer\Controllers;

use Illuminate\Routing\Controller;

/**
 * WelcomeController
 *
 * @package imlooke\installer
 * @author lwx12525 <lwx12525@qq.com>
 */
class WelcomeController extends Controller
{
    /**
     * 欢迎页
     *
     * @return View
     */
    public function welcome()
    {
        return view('vendor.installer.welcome');
    }
}
