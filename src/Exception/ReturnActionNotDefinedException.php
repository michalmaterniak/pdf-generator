<?php

namespace App\Exception;

class ReturnActionNotDefinedException extends MessageValidationException
{
    public function __construct()
    {
        parent::__construct("Return action callback not defined. You must defined callback action");
    }
}