<?php

namespace Imlooke\Installer\Support;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Imlooke\Installer\Exceptions\JsonException;
use PDO;
use Symfony\Component\Console\Output\BufferedOutput;

/**
 * DatabaseManager
 *
 * @package imlooke\installer
 * @author lwx12525 <lwx12525@qq.com>
 */
class DatabaseManager
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * @var \Symfony\Component\Console\Output\BufferedOutput
     */
    protected $outputLog;

    /**
     * 运行迁移和填充
     *
     * @param  Request $request
     * @return void
     */
    public function migrateAndSeed($request)
    {
        $this->request = $request;
        $this->outputLog = new BufferedOutput;

        $this->checkConnection();
        $this->migrate();
        $this->seed();
        $this->createAdminAccount();

        // return $this->outputLog->fetch();
    }

    /**
     * 检查数据库连接状态
     *
     * @return void
     */
    protected function checkConnection()
    {
        try {
            $data = $this->request->all();

            // 检查数据库连接状态，并且尝试创建数据库
            $dsn = "mysql:host={$data['db_host']};port={$data['db_port']}";
            $pdo = new PDO($dsn, $data['db_username'], $data['db_password']);
            $sql = "CREATE DATABASE IF NOT EXISTS `{$data['db_database']}`" .
                "DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";
            $pdo->exec($sql);

            // 检查 laravel 数据库连接是否正确
            DB::connection('mysql')->getPdo();
        } catch (Exception $e) {
            throw new JsonException($e->getMessage());
        }
    }

    /**
     * 运行迁移
     *
     * @return void
     */
    protected function migrate()
    {
        try {
            $migrationPaths = array_unique(config('installer.migration_paths'));
            $migrationPaths = collect($migrationPaths)->mapWithKeys(function ($item) {
                return ['--path' => $item];
            })->toArray();

            $options = array_merge($migrationPaths, [
                '--force' => true
            ]);

            Artisan::call('migrate', $options, $this->outputLog);
        } catch (Exception $e) {
            throw new JsonException($e->getMessage());
        }
    }

    /**
     * 运行填充
     *
     * @return void
     */
    protected function seed()
    {
        try {
            $seedClasses = config('installer.seed_classes');
            array_push($seedClasses, 'DatabaseSeeder');
            $seedClasses = array_unique($seedClasses);

            foreach ($seedClasses as $key => $seedClass) {
                $options = [
                    '--force' => true,
                    '--class' => $seedClass
                ];
                Artisan::call('db:seed', $options, $this->outputLog);
            }
        } catch (Exception $e) {
            throw new JsonException($e->getMessage());
        }
    }

    /**
     * 创建超级管理员
     *
     * @return void
     */
    protected function createAdminAccount()
    {
        $account = $this->request->only(['admin_username', 'admin_password', 'admin_email']);
        // TODO:
    }
}
