<?php

namespace App\MessageHandler;

use App\Message\PdfGenerate;
use App\MessageBus\AppMessageBusInterface;
use CommitM\PDFRator\PdfDriverResolver;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsMessageHandler(fromTransport: 'inside', method: 'handle')]
class PdfGeneratorHandler
{
    public function __construct(protected PdfDriverResolver $driverResolver, protected AppMessageBusInterface $messageBus)
    {}

    /**
     * @throws TransportExceptionInterface
     */
    public function handle(PdfGenerate $message): void
    {
        $driver = $this->driverResolver->getDriver($message->getDriver());
        $driver->setData($message->getContent());

        $path = $driver->getPath();

        $file = fopen($path, 'r');
        $client = HttpClient::create();

        try {
            $client->request(
                'POST',
                $message->getCallback(), [
                    'headers'=>[
                        'Content-Type'=> 'multipart/form-data'
                    ],
                    'body'=>[
                        'file'=> $file
                    ]
                ]
            );
        } catch (ClientExceptionInterface $e) {
            $this->messageBus->failed($message);
        }
    }
}