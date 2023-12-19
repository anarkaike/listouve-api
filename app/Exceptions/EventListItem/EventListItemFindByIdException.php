<?php

namespace App\Exceptions\EventListItem;

use App\Http\Responses\ApiErrorResponse;
use App\Exceptions\BaseException;
use Throwable;

class EventListItemFindByIdException extends BaseException
{
    public function __construct(string $message = null, int $code = 400, Throwable $previous = null)
    {
        if (!$message) $message = $this->getDefaultMessage();
        parent::__construct(message: $message, code: $code, previous: $previous);
    }

    public function apiResponse(string $message = null)
    {
        if (!$message) $message = $this->getDefaultMessage();
        return new ApiErrorResponse(data: [], message: $this->message);
    }

    public function __toString()
    {
        return 'Mensagem de erro: ' . $this->getMessage() . ' ||| String Trace: ' . $this->getTraceAsString();
    }

    public function getDefaultMessage()
    {
        return trans(key: 'messages.events_lists_items.find_by_id_error');
    }
}
