<?php


namespace App\Exceptions;


use Throwable;

class BanknotesException extends \Exception
{

    public function __construct($message = "Undefined banknotes", $code = 100, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }


}
