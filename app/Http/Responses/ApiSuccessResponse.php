<?php

namespace App\Http\Responses;

use Illuminate\{
    Contracts\Support\Responsable,
    Http\Response,
};

/**
 * Classe para padronizar oo retornos da API exitosos
 */
class ApiSuccessResponse implements Responsable
{
    /**
     * @param  mixed  $data
     * @param  array  $metadata
     * @param  int  $code
     * @param  array  $headers
     */
    public function __construct(
        private mixed $data,
        private string $message = 'End point executado com sucesso!',
        private array $metadata = [],
        private int $code = Response::HTTP_OK,
        private array $headers = []
    ) {}

    /**
     * @param  $request
     * @return \Symfony\Component\HttpFoundation\Response|void
     */
    public function toResponse($request)
    {
        return response()->json(
            [
                'success' => true,
                'message' => $this->message,
                'data' => $this->data,
                'metadata' => $this->metadata,
            ],
            $this->code,
            $this->headers
        );
    }
}
