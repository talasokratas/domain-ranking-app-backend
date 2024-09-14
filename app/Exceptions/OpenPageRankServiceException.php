<?php


namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class OpenPageRankServiceException extends Exception
{
    protected $message = 'Request to Open Page Rank is sent, but no response given, check API url or key';

    public function report()
    {
        Log::error('Open Page Rank error: ' . $this->getMessage());
    }
}
