<?php

namespace Imlooke\Installer\Exceptions;

use Exception;

/**
 * JsonException
 *
 * @package imlooke\installer
 * @author lwx12525 <lwx12525@qq.com>
 */
class JsonException extends Exception
{
    /**
     * 构造方法
     *
     * @param string $message
     * @param integer $code
     */
    public function __construct(string $message = '', int $code = 422)
    {
        parent::__construct($message, $code);
    }

    /**
     * 返回错误信息
     *
     * @return Response
     */
    public function render()
    {
        return response()->json([
            'message' => $this->message
        ], $this->code);
    }
}
