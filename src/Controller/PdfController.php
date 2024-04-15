<?php

namespace App\Controller;

use App\DTO\ContentPdfDto;
use App\Message\PdfGenerate;
use App\MessageBus\AppMessageBusInterface;
use CommitM\PDFRator\PdfDriverResolver;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class PdfController
{
    protected ContentPdfDto|null $contentPdfDto;

    public function __construct(RequestStack $requestStack)
    {
        $this->contentPdfDto = $requestStack->getCurrentRequest()->attributes->get('contentPdfDto');
    }

    #[Route(path: '/generate', name: 'pdf-generate', methods: ['POST'])]
    public function generate(AppMessageBusInterface $messageBus): Response
    {
        $messageBus->inside(PdfGenerate::createByDto($this->contentPdfDto));

        return new JsonResponse([], Response::HTTP_ACCEPTED);
    }

    #[Route(path: '/pdf', name: 'pdf', methods: ['POST'])]
    public function pdf(PdfDriverResolver $driverResolver): Response
    {
        $driver = $driverResolver->getDriver($this->contentPdfDto->getDriver());
        $driver->setData($this->contentPdfDto->getData());

        return new BinaryFileResponse($driver->getPath());
    }
}