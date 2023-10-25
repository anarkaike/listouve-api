<?php

namespace App\Exceptions\Event;

use App\Http\Responses\ApiErrorResponse;
use App\Exceptions\BaseException;
use Throwable;

/**
 * Classe de exceção para erro generico de criação de evento
 */
class EventCreateException extends BaseException
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = null, int $code = 400, Throwable $previous = null)
    {
        if (!$message) $message = $this->getDefaultMessage();
        parent::__construct(message: $message, code: $code, previous: $previous);
    }

    /**
     * Response de erro paar ser usado dentro do controlador
     *
     * @param string|null $message
     * @return ApiErrorResponse
     */
    public function apiResponse(string $message = null)
    {
        if (!$message) $message = $this->getDefaultMessage();
        return new ApiErrorResponse(data: [], message: $this->message);
    }

    /**
     * String que será printada se a exceção for usada como string
     *
     * @return string
     */
    public function __toString()
    {
        return 'Mensagem de erro: ' . $this->getMessage() . ' ||| String Trace: ' . $this->getTraceAsString();
    }

    /**
     * Mensagem padrão para erro de criação de evento
     *
     * @return string
     */
    public function getDefaultMessage()
    {
        return "Erro ao tentar criar um evento.";
    }
}
