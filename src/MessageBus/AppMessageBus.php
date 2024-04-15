<?php

namespace App\MessageBus;

use App\Message\MessageInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\TransportNamesStamp;

class AppMessageBus implements AppMessageBusInterface
{
    public function __construct(protected MessageBusInterface $messageBus)
    {}

    protected function dispatch(object $message, array $stamps = []): Envelope
    {
        return $this->messageBus->dispatch($message, $stamps);
    }

    public function inside(MessageInterface $message): Envelope
    {
        return $this->dispatch(
            $message,
            [
                new TransportNamesStamp(self::DEFAULT),
            ]
        );
    }

    public function failed(MessageInterface $message): Envelope
    {
        return $this->dispatch(
            $message,
            [
                new TransportNamesStamp(self::FAILED),
            ]
        );
    }
}