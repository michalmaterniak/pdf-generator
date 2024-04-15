<?php

namespace CommitM\PDFRator;

use CommitM\PDFRator\DependencyInjection\Compiler\ResourcesContainerPass;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class PDFRatorBundle extends AbstractBundle
{
    protected string $name = 'pdfrator';

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new ResourcesContainerPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, -5);
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import(__DIR__ . '/../config/services.xml');
        $container->parameters()->set('pdfrator', $config);
    }

    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->import(__DIR__ . '/../config/drivers.php');
    }
}