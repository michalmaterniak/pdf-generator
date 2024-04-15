<?php

namespace App\MessageHandler;

use App\DTO\ContentPdfDto;
use App\Message\Outside;
use App\Message\PdfGenerate;
use App\MessageBus\AppMessageBusInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[AsMessageHandler(fromTransport: 'outside_receive', method: 'handle')]
class OutsideReceiverHandler
{
    public function __construct(protected ValidatorInterface $validator, protected AppMessageBusInterface $messageBus)
    {}

    public function handle(Outside $message): void
    {
        $body = json_decode($message->getJson(), true);
        $driver = $body['driver'] ?? '';
        $data = $body['data'] ?? [];
        $callback = $body['callback'] ?? '';

        $contentDto = new ContentPdfDto($driver, $data, $callback);
        $errors = $this->validator->validate($contentDto);

        if ($errors->count() > 0) {
            $this->messageBus->failed(PdfGenerate::createByDto($contentDto));

            return;
        }

        $this->messageBus->inside(PdfGenerate::createByDto($contentDto));
    }
}