<?php

namespace Parabol\LocaleAdminBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('parabol_locale_admin');

        $rootNode
            ->children()
                ->scalarNode('default_transaltions_file')
                    ->cannotBeEmpty()
                    ->defaultValue('../app/Resources/translations/messages.en.yml')
                ->end()
                ->arrayNode('admin_menu')
                    ->prototype('array')
                        ->children()
                            ->scalarNode('name')->end()
                            ->scalarNode('label')->end()
                            ->scalarNode('route')->end()
                            ->scalarNode('icon')->end()
                            ->scalarNode('parent')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}
