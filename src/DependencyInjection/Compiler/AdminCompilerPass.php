<?php

namespace App\DependencyInjection\Compiler;

use App\Admin\AuthorAdmin;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class AdminCompilerPass.
 *
 * @author Phuc Vo <van-phuc.vo@ekino.com>
 */
class AdminCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        // Override sonata.user.admin.user service
        $container
            ->getDefinition('sonata.user.admin.user')
            ->setClass(AuthorAdmin::class)
        ;
    }
}
