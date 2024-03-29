<?php

namespace App\Http\Responses;

use Illuminate\{
    Contracts\Support\Responsable,
    Http\Request,
};

/**
 * Classe para padronizar oo retornos da API contendo erros
 */
class ApiErrorResponse implements Responsable
{
    /**
     * @param  mixed  $data
     * @param  array  $metadata
     * @param  int  $code
     * @param  array  $headers
     */
    public function __construct(
        private \Exception $exception ,
        private ?string $message = null,
        private array $data = [],
        Request|null $request = null,
    ) {}

    /**
     * @param  $request
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function toResponse($request = null)
    {
        return response()->json(
            [
                'success' => false,
                'message' => $this->message ?? $this->exception->getMessage(),
                'code' => method_exists($this->exception, 'getMessageCode') ? $this->exception->getMessageCode() : null,
                'data' => $this->data,
                'exception' => $this->exception->getTrace()
            ],
            400,
            []
        );
    }
}
