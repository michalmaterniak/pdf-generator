<?php

namespace CommitM\PDFRator;

use mikehaertl\wkhtmlto\Pdf;

class WkhtmltopdfDriver implements PdfDriverInterface
{
    protected Pdf $pdfMaker;

    private string $html;

    protected array $options = [];

    private function generateHash(): string
    {
        return uniqid(str_replace('.', '', (string)microtime(true)));
    }

    public function setData(array $data): void
    {
        $this->html = (string)$data['html'];
        $this->options = $data['options'] ?? [];

        $this->generate();
    }

    protected function generate(): void
    {
        $this->pdfMaker = new Pdf($this->html);
        $this->pdfMaker->setOptions($this->options);
    }

    public function getPath(): string
    {
        $path = "/tmp/" . $this->generateHash() . ".pdf";

        if (!$this->pdfMaker->saveAs($path)) {
            throw new \Exception("Can't save PDF");
        }

        return $path;
    }

    public function getAsString(): string
    {
        return $this->pdfMaker->toString();
    }
}