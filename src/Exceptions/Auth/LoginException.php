<?php

namespace ErenMustafaOzdal\LaravelUserModule\Exceptions\Auth;

use Exception;

class LoginException extends Exception
{
    private $datas;

    public function __construct($datas, $message = "", $code = 0, Exception $previous = null)
    {
        $this->datas = $datas;

        parent::__construct($message, $code, $previous);
    }

    public function getDatas()
    {
        return $this->datas;
    }
}
