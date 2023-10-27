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
        private \Exception $exception,
        private string $message = 'Erro ao executar a end poiny da api.',
        private array $data = [],
        Request|null $request = null,
    ) {}

    /**
     * @param  $request
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function toResponse($request)
    {
        return response()->json(
            [
                'success' => false,
                'message' => $this->message ?? $this->exception->getMessage(),
                'data' => $this->data,
                'exception' => $this->exception->getTrace()
            ],
            400,
        );
    }
}
