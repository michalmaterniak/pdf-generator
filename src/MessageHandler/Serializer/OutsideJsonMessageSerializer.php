<?php

namespace App\MessageHandler\Serializer;

use App\Message\Outside;
use App\MessageBus\AppMessageBusInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\TransportNamesStamp;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class OutsideJsonMessageSerializer implements SerializerInterface
{
    public function decode(array $encodedEnvelope): Envelope
    {
        return new Envelope(
            new Outside($encodedEnvelope['body']),
            [
                new TransportNamesStamp(AppMessageBusInterface::RECEIVE),
            ]
        );
    }

    public function encode(Envelope $envelope): array
    {
        throw new \ErrorException('not implemented');
    }
}