<?php
/**
 * Created by PhpStorm.
 * User: daniel
 * Date: 29.01.17
 * Time: 23:11
 */

namespace AppBundle\DependencyInjection\Compiler;


use Symfony\Component\Config\Resource\DirectoryResource;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Finder\Finder;

class ValidatorPass implements CompilerPassInterface
{
    const VALIDATION_PATH = '/../../Resources/validation';
    public function process(ContainerBuilder $container)
    {
        $validatorBuilder = $container->getDefinition('validator.builder');
        $validatorFiles = array();
        $finder = new Finder();

        foreach ($finder->files()->in(__DIR__ . self::VALIDATION_PATH) as $file) {
            $validatorFiles[] = $file->getRealPath();
        }

        $validatorBuilder->addMethodCall('addYamlMappings', array($validatorFiles));

        $container->addResource(new DirectoryResource(__DIR__ . self::VALIDATION_PATH));
    }
}