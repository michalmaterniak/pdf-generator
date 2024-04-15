<?php
namespace App\Message;

use App\DTO\ContentPdfDto;

readonly class PdfGenerate implements MessageInterface
{
    public function __construct(protected string $driver, protected array $content, protected string $callback)
    {}

    public static function createByDto(ContentPdfDto $contentPdfDto): static
    {
        return new static($contentPdfDto->getDriver(), $contentPdfDto->getData(), $contentPdfDto->getCallback());
    }

    public function getDriver(): string
    {
        return $this->driver;
    }

    public function getContent(): array
    {
        return $this->content;
    }

    public function getCallback(): string
    {
        return $this->callback;
    }
}