<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

class DriverExists extends Constraint
{
    public string $message = 'Driver "{{ string }}" nie został załadowany poprawnie bądź nie istnieje.';
}