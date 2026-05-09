<?php

namespace App\Exceptions;

use Exception;

class BusinessException extends Exception
{
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
    public function render(Request $request): Response
    {
        return response()->json(['message'=>$this->getMessage()],400);
    }
}
