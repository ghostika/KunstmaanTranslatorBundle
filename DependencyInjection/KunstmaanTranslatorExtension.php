<?php

namespace Kunstmaan\TranslatorBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class KunstmaanTranslatorExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if ($config['enabled'] === false) {
            return;
        }

        $container->setParameter('kuma_translator.enabled', $config['enabled']);
        $container->setParameter('kuma_translator.managed_locales', $config['managed_locales']);
        $container->setParameter('kuma_translator.file_formats', $config['file_formats']);
        $container->setParameter('kuma_translator.storage_engine.type', $config['storage_engine']['type']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
        $loader->load('repositories.yml');
    }
}