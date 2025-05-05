<?php

namespace Tourze\JsonRPCCallerBundle\Tests\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tourze\JsonRPCCallerBundle\DependencyInjection\JsonRPCCallerExtension;

class JsonRPCCallerExtensionTest extends TestCase
{
    private JsonRPCCallerExtension $extension;
    private ContainerBuilder $container;

    protected function setUp(): void
    {
        $this->extension = new JsonRPCCallerExtension();
        $this->container = new ContainerBuilder();
    }

    public function testLoad_withEmptyConfig_loadsServices(): void
    {
        $this->extension->load([], $this->container);

        // 验证服务定义已加载
        $this->assertTrue($this->container->hasDefinition('Tourze\JsonRPCCallerBundle\Repository\ApiCallerRepository')
            || $this->container->hasAlias('Tourze\JsonRPCCallerBundle\Repository\ApiCallerRepository'));
    }
}
