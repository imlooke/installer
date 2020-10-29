<?php

namespace Imlooke\Installer\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Imlooke\Installer\Support\DatabaseManager;
use Imlooke\Installer\Support\EnvironmentManager;

/**
 * EnvironmentController
 *
 * @package imlooke\installer
 * @author lwx12525 <lwx12525@qq.com>
 */
class EnvironmentController extends Controller
{
    /**
     * @var EnvironmentManager
     */
    protected $environmentManager;

    /**
     * @var DatabaseManager
     */
    protected $databaseManager;

    /**
     * @param EnvironmentManager $environmentManager
     * @param DatabaseManager $databaseManager
     */
    public function __construct(
        EnvironmentManager $environmentManager,
        DatabaseManager $databaseManager
    ) {
        $this->environmentManager = $environmentManager;
        $this->databaseManager = $databaseManager;
    }

    /**
     * 保存环境变量
     *
     * @param  Request $request
     * @return View
     */
    public function environment(Request $request)
    {
        $this->environmentManager->validateForm($request);
        $this->environmentManager->saveEnvFile($request);

        // 运行数据表迁移和填充
        $this->databaseManager->migrateAndSeed($request);
    }
}
