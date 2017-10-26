<?php

namespace Parabol\LocaleAdminBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class ParabolLocaleAdminExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('parabol_locale_admin.source_transaltions_file', $config['source_transaltions_file']);   

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    public function set($container, $config, $fullname, $name, $default)
    {

        if(!isset($config[$name]) || empty($config[$name]))
        {
            
            $config[$name] = $default;
        }

        $container->setParameter($fullname, array_merge($container->getParameter($fullname), $config[$name]));
    }
}
