<?php
namespace App\Message;

readonly class Outside implements MessageInterface
{
    public function __construct(protected string $json)
    {}

    public function getJson(): string
    {
        return $this->json;
    }
}