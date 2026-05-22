<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Exception;

class BusinessException extends Exception
{
    public function __construct(
        string $message,
        private int $statusCode = 400
    ) {
        parent::__construct($message);
    }
    /**
     * Report the exception.
     */
    public function report(): void
    {
        logger()->warning($this->getMessage(),['exception'=>$this]);
    }
 
    /**
     * Render the exception as an HTTP response.
     */
    public function render(Request $request): JsonResponse
    {
         return response()->json([
            'message' => $this->getMessage()
        ], $this->statusCode);
    }
}
