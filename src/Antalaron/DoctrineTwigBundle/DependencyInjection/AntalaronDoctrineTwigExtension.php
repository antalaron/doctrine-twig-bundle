<?php

/*
 * (c) Antal Áron <antalaron@antalaron.hu>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Antalaron\DoctrineTwigBundle\DependencyInjection;

use Antalaron\DoctrineTwigBundle\Model\TemplateInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * AntalaronDoctrineTwigExtension.
 *
 * @author Antal Áron <antalaron@antalaron.hu>
 */
class AntalaronDoctrineTwigExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    /**
     * {@inheritdoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('entity_resolver.yml');

        $doctrine = [
            'orm' => [
                'resolve_target_entities' => [
                    TemplateInterface::class => '%antalaron_doctrine_twig.target_entity_resolver.template.class%',
                ],
            ],
        ];

        $container->prependExtensionConfig('doctrine', $doctrine);
    }
}
