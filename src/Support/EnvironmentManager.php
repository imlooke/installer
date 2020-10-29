<?php

namespace Imlooke\Installer\Support;

use Exception;
use Illuminate\Encryption\Encrypter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Imlooke\Installer\Exceptions\JsonException;
use Imlooke\Installer\Exceptions\ValidationException;

/**
 * EnvironmentManager
 *
 * @package imlooke\installer
 * @author lwx12525 <lwx12525@qq.com>
 */
class EnvironmentManager
{
    /**
     * @var string
     */
    protected $envPath;

    /**
     * @var string
     */
    protected $envExamplePath;

    /**
     * 设置 .env .env.example 文件路径
     */
    public function __construct()
    {
        $this->envPath = base_path('.env');
        $this->envExamplePath = base_path('.env.example');
        $this->genEnvFile();
    }

    /**
     * 生成 .env 文件
     *
     * @return void
     */
    public function genEnvFile()
    {
        if (!file_exists($this->envPath)) {
            if (file_exists($this->envExamplePath)) {
                copy($this->envExamplePath, $this->envPath);
            } else {
                touch($this->envPath);
            }
        }
    }

    /**
     * 更新 .env 文件
     *
     * @param  Request $request
     * @return void
     */
    public function saveEnvFile(Request $request)
    {
        $appEnv = $request->has('app_env') ? $request->app_env : 'production';
        $appKey = 'base64:' . base64_encode(
            Encrypter::generateKey(config('app.cipher'))
        );
        $appDebug = $request->has('app_debug') ? $request->app_debug : false;

        $envFileData = <<<parse
APP_NAME=$request->app_name
APP_ENV=$appEnv
APP_KEY=$appKey
APP_DEBUG=$appDebug
APP_URL=$request->app_url

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=$request->db_host
DB_PORT=$request->db_port
DB_DATABASE=$request->db_database
DB_USERNAME=$request->db_username
DB_PASSWORD=$request->db_password
DB_PREFIX=$request->db_prefix

BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=null
MAIL_FROM_NAME="\${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_APP_CLUSTER=mt1

MIX_PUSHER_APP_KEY="\${PUSHER_APP_KEY}"
MIX_PUSHER_APP_CLUSTER="\${PUSHER_APP_CLUSTER}"

parse;

        try {
            file_put_contents($this->envPath, $envFileData);
        } catch (Exception $e) {
            throw new JsonException('无法保存 .env 文件，请手动创建它。');
        }
    }

    /**
     * 验证字段
     *
     * @param  Request $request
     * @return void
     */
    public function validateForm(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            config('installer.environment_form.rules'),
            [],
            config('installer.environment_form.attributes')
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
