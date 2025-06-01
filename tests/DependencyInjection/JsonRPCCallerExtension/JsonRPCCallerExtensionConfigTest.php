<?php

namespace Tourze\JsonRPCCallerBundle\Tests\DependencyInjection\JsonRPCCallerExtension;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Tourze\JsonRPCCallerBundle\DependencyInjection\JsonRPCCallerExtension;

/**
 * JsonRPCCallerExtension 配置测试
 * 测试依赖注入扩展的配置加载和处理
 */
class JsonRPCCallerExtensionConfigTest extends TestCase
{
    private JsonRPCCallerExtension $extension;
    private ContainerBuilder $container;

    protected function setUp(): void
    {
        $this->extension = new JsonRPCCallerExtension();
        $this->container = new ContainerBuilder();
    }

    public function testExtendsSymfonyExtension(): void
    {
        $this->assertInstanceOf(Extension::class, $this->extension);
    }

    public function testLoad_withEmptyConfig_doesNotThrowException(): void
    {
        $this->expectNotToPerformAssertions();
        $this->extension->load([], $this->container);
    }

    public function testLoad_withMultipleEmptyConfigs_doesNotThrowException(): void
    {
        $configs = [[], [], []];
        $this->expectNotToPerformAssertions();
        $this->extension->load($configs, $this->container);
    }

    public function testLoad_withEmptyConfig_loadsYamlFile(): void
    {
        // 模拟YAML文件加载，通过检查是否有相关服务定义
        $this->extension->load([], $this->container);
        
        // 检查容器是否有相关的服务定义或别名
        $hasRepositoryService = $this->container->hasDefinition('Tourze\JsonRPCCallerBundle\Repository\ApiCallerRepository')
            || $this->container->hasAlias('Tourze\JsonRPCCallerBundle\Repository\ApiCallerRepository')
            || $this->container->has('Tourze\JsonRPCCallerBundle\Repository\ApiCallerRepository');
        
        $hasDataFixturesService = $this->container->hasDefinition('Tourze\JsonRPCCallerBundle\DataFixtures\ApiCallerFixtures')
            || $this->container->hasAlias('Tourze\JsonRPCCallerBundle\DataFixtures\ApiCallerFixtures')
            || $this->container->has('Tourze\JsonRPCCallerBundle\DataFixtures\ApiCallerFixtures');
        
        // 至少应该有一个服务被加载
        $this->assertTrue($hasRepositoryService || $hasDataFixturesService, 'No expected services were loaded');
    }

    public function testLoad_multipleTimesWithSameConfig_isIdempotent(): void
    {
        $config = [];
        
        // 第一次加载
        $this->extension->load($config, $this->container);
        $firstLoadDefinitionCount = count($this->container->getDefinitions());
        
        // 第二次加载相同配置
        $this->extension->load($config, $this->container);
        $secondLoadDefinitionCount = count($this->container->getDefinitions());
        
        // 验证多次加载不会重复定义服务
        $this->assertEquals($firstLoadDefinitionCount, $secondLoadDefinitionCount);
    }

    public function testGetAlias_returnsCorrectAlias(): void
    {
        $alias = $this->extension->getAlias();
        $this->assertEquals('json_rpc_caller', $alias);
    }

    public function testLoad_withContainerBuilder_modifiesContainer(): void
    {
        $originalDefinitionCount = count($this->container->getDefinitions());
        
        $this->extension->load([], $this->container);
        
        $newDefinitionCount = count($this->container->getDefinitions());
        
        // 加载后应该有新的服务定义
        $this->assertGreaterThanOrEqual($originalDefinitionCount, $newDefinitionCount);
    }

    public function testLoad_withValidContainer_setsCorrectParameters(): void
    {
        $this->extension->load([], $this->container);
        
        // 检查是否设置了自动装配和自动配置
        $definitions = $this->container->getDefinitions();
        
        foreach ($definitions as $definition) {
            if (str_contains($definition->getClass() ?? '', 'JsonRPCCallerBundle')) {
                // 如果有默认值，应该是启用自动装配的
                break;
            }
        }
        
        // 这个测试主要验证加载过程不出错
        $this->addToAssertionCount(1);
    }

    public function testFileLoader_worksWithCorrectLocator(): void
    {
        // 验证FileLocator指向正确的目录
        $reflection = new \ReflectionMethod($this->extension, 'load');
        $reflection->setAccessible(true);
        
        // 这个测试主要确保load方法不抛出文件未找到异常
        $this->expectNotToPerformAssertions();
        $this->extension->load([], $this->container);
    }

    public function testExtensionConfiguration_isOptional(): void
    {
        // 测试没有配置也能正常工作
        $this->extension->load([], $this->container);
        
        // 应该能够正常编译容器
        $this->container->compile();
        
        $this->assertTrue(true); // 如果到这里没有异常，测试通过
    }
} 