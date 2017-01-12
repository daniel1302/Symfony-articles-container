<?php
namespace CourseBundle\DependencyInjection\Compiler;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class CustomCompilerPass implements CompilerPassInterface {
    public function process(ContainerBuilder $container)
    {
        // always first check if the primary service is defined
        if (!$container->has('app.order_notification')) {
            return;
        }

        $definition = $container->findDefinition('app.order_notification');

        // find all service IDs with the app.mail_transport tag
        $taggedServices = $container->findTaggedServiceIds('order_handler');

        foreach ($taggedServices as $id => $tags) {
            // add the transport service to the ChainTransport service
            $definition->addMethodCall('addHandler', array(new Reference($id)));
        }
    }
}
