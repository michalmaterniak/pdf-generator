<?php

namespace CommitM\PDFRator;

use CommitM\PDFRator\Exception\DriverNotExistsException;
use CommitM\PDFRator\Exception\DriversNotExistsException;

class PdfDriverResolver
{
    /**
     * @var PdfDriverInterface[] $drivers
     */
    protected array $drivers = [];

    public function __construct(protected array $classes)
    {
        if (count($this->classes) === 0) {
            throw new DriversNotExistsException();
        }

        foreach ($this->classes as $name => $data) {
            if (!class_exists($data['driver'])) {
                throw new DriverNotExistsException($data['driver']);
            }

            $this->drivers[$name] = new $data['driver']();
        }
    }

    public function hasDriver(string $name): bool
    {
        return isset($this->drivers[$name]);
    }

    public function getDriver(string $name): PdfDriverInterface
    {
        return $this->drivers[$name];
    }
}