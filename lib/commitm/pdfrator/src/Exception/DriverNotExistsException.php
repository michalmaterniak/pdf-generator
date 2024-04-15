<?php

namespace CommitM\PDFRator\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DriverNotExistsException extends NotFoundHttpException
{
    public function __construct(string $name)
    {
        parent::__construct("Driver class {$name} does not exist");
    }
}