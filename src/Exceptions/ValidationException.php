<?php

namespace Imlooke\Installer\Exceptions;

use Exception;

/**
 * ValidationException
 *
 * @package imlooke\installer
 * @author lwx12525 <lwx12525@qq.com>
 */
class ValidationException extends Exception
{
    /**
     * @var \Illuminate\Contracts\Validation\Validator
     */
    public $validator;

    /**
     * 构造方法
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     */
    public function __construct($validator)
    {
        parent::__construct('表单输入错误。', 422);
        $this->validator = $validator;
    }

    /**
     * 返回错误信息
     *
     * @return Response
     */
    public function render()
    {
        return response()->json([
            'message' => $this->message,
            'errors' => $this->validator->errors(),
        ], 422);
    }
}
