<?php

namespace App\MessageBus;

use App\Message\MessageInterface;
use Symfony\Component\Messenger\Envelope;

interface AppMessageBusInterface
{
    const string DEFAULT = 'inside';

    const string RECEIVE = 'outside_receive';

    const string FAILED = 'failed';

    public function inside(MessageInterface $message): Envelope;

    public function failed(MessageInterface $message): Envelope;
}