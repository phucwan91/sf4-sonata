<?php

namespace App\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class PageAdminCompilerPass.
 *
 * @author Phuc Vo <van-phuc.vo@ekino.com>
 */
class PageAdminCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $container
            ->getDefinition('sonata.page.admin.page')
            ->addArgument($container->getParameter('app.sites.configuration'))
            ->addMethodCall('setUserContext', [new Reference('app.security.user_context')]);
    }
}
