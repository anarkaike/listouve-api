<?php

namespace App\Exceptions\Permission;

use App\Http\Responses\ApiErrorResponse;
use App\Exceptions\BaseException;


class PermissionDeleteException extends BaseException
{
    public function __construct(string $message = 'Erro ao tentar deletar o usuário.', int $code = 0, \Throwable $previous = null)
    {
        if (!$message) $message = $this->getDefaultMessage();
        parent::__construct(message: $message, code: $code, previous: $previous);
    }

    public function apiResponse(string $message = null)
    {
        if (!$message) $message = $this->getDefaultMessage();
        return new ApiErrorResponse(data: [], message: $this->message);
    }

    public function __toString() {
        return 'Mensagem de erro: ' . $this->getMessage() . ' ||| String Trace: ' . $this->getTraceAsString();
    }

    public function getDefaultMessage() {
        return trans(key: 'messages.permissions.delete_error');
    }
}
