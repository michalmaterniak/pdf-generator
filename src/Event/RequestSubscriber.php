<?php

namespace App\Event;

use App\DTO\ContentPdfDto;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestSubscriber implements EventSubscriberInterface
{
    public function __construct(protected ValidatorInterface $validator)
    {}

    public static function getSubscribedEvents(): array
    {
        return [
            ControllerEvent::class => 'onKernelController',
            RequestEvent::class => 'onKernelRequest',
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $content = json_decode($request->getContent(), true);

        if (!$content) {
            return;
        }

        $contentPdfDto = new ContentPdfDto(
            $content['driver'] ?? '',
            $content['data'] ?? [],
            $content['callback'] ?? '',
        );

        $request->attributes->set('contentPdfDto', $contentPdfDto);
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $request = $event->getRequest();
        $contentPdfDto = $request->attributes->get('contentPdfDto');

        if (!$contentPdfDto) {
            return;
        }

        $errors = $this->validator->validate($contentPdfDto);

        if (count($errors) > 0) {
            $event->setController(function () use ($errors) {
                return new JsonResponse(['errors' => (string)$errors], Response::HTTP_BAD_REQUEST);
            });
        }
    }
}