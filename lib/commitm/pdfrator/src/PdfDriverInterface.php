<?php

namespace CommitM\PDFRator;

interface PdfDriverInterface
{
    public function setData(array $data);

    public function getPath(): string;

    public function getAsString(): string;
}