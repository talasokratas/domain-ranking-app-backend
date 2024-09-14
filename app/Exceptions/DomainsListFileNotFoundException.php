<?php


namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class DomainsListFileNotFoundException extends Exception
{
    protected $message = 'Could not find json file containing domains list';

    public function report()
    {
        Log::error('domains file error: ' . $this->getMessage());
    }
}
