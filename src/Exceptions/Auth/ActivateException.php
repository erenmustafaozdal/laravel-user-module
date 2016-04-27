<?php

namespace ErenMustafaOzdal\LaravelUserModule\Exceptions\Auth;

use Exception;

class ActivateException extends Exception
{
    private $id;
    private $activation_code;
    private $type;

    public function __construct($id, $activation_code, $type, $message = "", $code = 0, Exception $previous = null)
    {
        $this->id = $id;
        $this->activation_code = $activation_code;
        $this->type = $type;

        parent::__construct($message, $code, $previous);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getActivationCode()
    {
        return $this->activation_code;
    }

    public function getType()
    {
        return $this->type;
    }
}
