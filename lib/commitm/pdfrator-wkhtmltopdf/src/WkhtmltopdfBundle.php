<?php

namespace CommitM\PDFRator;

use CommitM\PDFRator\DependencyInjection\Compiler\InjectDriverPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class WkhtmltopdfBundle extends AbstractBundle
{
    protected string $name = 'wkhtmltopdf';

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        if (!$container->hasExtension('pdfrator')) {
            throw new \ErrorException('PDFRatorBundle not loaded!');
        }

        $container->addCompilerPass(new InjectDriverPass($this->name, WkhtmltopdfDriver::class));
    }
}