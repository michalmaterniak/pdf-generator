<?php

namespace CommitM\PDFRator\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class InjectDriverPass implements CompilerPassInterface
{
    public function __construct(protected string $name, protected string $driver)
    {}

    public function process(ContainerBuilder $container): void
    {
        $drivers = $container->getParameter('pdfrator');
        $drivers['drivers'][$this->name] = ['driver' => $this->driver];
        $container->setParameter('pdfrator', $drivers);
    }
}