<?php

namespace App\DTO;

class ContentPdfDto implements \JsonSerializable
{
    protected string $driver;

    protected array $data;

    protected string $callback;

    public function __construct(string $driver, array $data, string $callback)
    {
        $this->driver = $driver;
        $this->data = $data;
        $this->callback = $callback;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getDriver(): string
    {
        return $this->driver;
    }

    public function getCallback(): string
    {
        return $this->callback;
    }

    public function jsonSerialize(): string {
        return json_encode(
            [
                'driver' => $this->driver,
                'data' => $this->data,
                'callback' => $this->callback
            ]
        );
    }
}
