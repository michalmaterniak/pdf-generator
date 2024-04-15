<?php

namespace CommitM\PDFRator\Exception;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DriversNotExistsException extends NotFoundHttpException
{
    public function __construct()
    {
        parent::__construct("There is no PDF's drivers");
    }
}