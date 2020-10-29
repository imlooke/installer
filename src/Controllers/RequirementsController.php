<?php

namespace Imlooke\Installer\Controllers;

use Illuminate\Routing\Controller;
use Imlooke\Installer\Support\RequirementsChecker;

/**
 * RequirementsController
 *
 * @package imlooke\installer
 * @author lwx12525 <lwx12525@qq.com>
 */
class RequirementsController extends Controller
{
    /**
     * 环境检查
     *
     * @param  RequirementsChecker $requirementsChecker
     * @return View
     */
    public function requirements(RequirementsChecker $requirementsChecker)
    {
        $response = $requirementsChecker->check();

        return $response;
    }
}
