<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 30.01.17
 * Time: 20:53
 */

namespace AppBundle\DependencyInjection\Compiler;


use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ArticleParserPass implements CompilerPassInterface
{

    public function process(ContainerBuilder $container)
    {
        if (!$container->has('app.article_parser')) {
            return;
        }

        $articleParserDefinition = $container->findDefinition('app.article_parser');

        $taggedServices = $container->findTaggedServiceIds('text_parser.article');

        foreach ($taggedServices as $id => $tags) {
            $articleParserDefinition->addMethodCall('addParser', [new Reference($id)]);
        }
    }
}