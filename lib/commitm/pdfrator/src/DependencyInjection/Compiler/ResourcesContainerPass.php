<?php

declare(strict_types=1);

namespace CommitM\PDFRator\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class ResourcesContainerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $pdfrator = $container->getParameter('pdfrator');
        $container->setParameter('pdfrator.drivers', $pdfrator['drivers'] ?? []);
    }
}
