<?php

namespace Knp\RadBundle\DependencyInjection\Definition;

use Symfony\Component\DependencyInjection\Definition;

class DoctrineRepositoryFactory
{
    public function createDefinition($className)
    {
        $definition = new Definition();
        $definition->setClass('Doctrine\Common\Persistence\ObjectRepository');
        $definition->setFactory('doctrine');
        $definition->setFactory('getRepository');
        $definition->setArguments(array($className));

        return $definition;
    }
}
