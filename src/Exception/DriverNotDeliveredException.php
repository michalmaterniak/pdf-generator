<?php

namespace App\Exception;

class DriverNotDeliveredException extends MessageValidationException
{
    public function __construct()
    {
        parent::__construct("Driver was not delivered");
    }
}