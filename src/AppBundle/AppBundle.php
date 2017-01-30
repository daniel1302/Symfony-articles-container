<?php

namespace AppBundle;

use AppBundle\DependencyInjection\Compiler\ArticleParserPass;
use AppBundle\DependencyInjection\Compiler\ValidatorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ValidatorPass());
        $container->addCompilerPass(new ArticleParserPass());
    }
}