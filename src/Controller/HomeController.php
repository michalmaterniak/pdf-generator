<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(protected KernelInterface $kernel)
    {
        if (!$kernel->isDebug()) {
            throw $this->createNotFoundException();
        }
    }

    #[Route(path: '/', name: 'pdf-home')]
    public function home(): Response
    {
        throw $this->createNotFoundException();
    }

    #[Route(path: '/upload', name: 'pdf-upload', methods: ['POST'])]
    public function upload(RequestStack $requestStack): Response
    {
        $request = $requestStack->getCurrentRequest();
        $path = $this->kernel->getCacheDir() . '/files/';

        if (!file_exists($path) && !mkdir($path, 0777, true)) {
            die('Failed to create directories...');
        }

        foreach ($request->files->keys() as $key) {
            /**
             * @var UploadedFile $file
             */
            $file = $request->files->get($key);
            $name = uniqid() . '_' . microtime(true) . '_' . $file->getClientOriginalName();
            file_put_contents($path . $name, $file->getContent());
        }

        return new Response('');
    }
}