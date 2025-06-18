<?php

namespace Tourze\JsonRPCCallerBundle\Tests\JsonRPCCallerBundle;

use PHPUnit\Framework\TestCase;
use Tourze\BundleDependency\BundleDependencyInterface;
use Tourze\DoctrineSnowflakeBundle\DoctrineSnowflakeBundle;
use Tourze\DoctrineTimestampBundle\DoctrineTimestampBundle;
use Tourze\DoctrineTrackBundle\DoctrineTrackBundle;
use Tourze\JsonRPCCallerBundle\JsonRPCCallerBundle;

/**
 * JsonRPCCallerBundle 依赖测试
 * 测试Bundle依赖接口实现和依赖Bundle配置
 */
class JsonRPCCallerBundleDependenciesTest extends TestCase
{
    private JsonRPCCallerBundle $bundle;

    protected function setUp(): void
    {
        $this->bundle = new JsonRPCCallerBundle();
    }

    public function testImplementsBundleDependencyInterface(): void
    {
        $this->assertInstanceOf(BundleDependencyInterface::class, $this->bundle);
    }

    public function testGetBundleDependencies_returnsCorrectDependencies(): void
    {
        $dependencies = JsonRPCCallerBundle::getBundleDependencies();
        $this->assertCount(3, $dependencies);
    }

    public function testGetBundleDependencies_containsDoctrineSnowflakeBundle(): void
    {
        $dependencies = JsonRPCCallerBundle::getBundleDependencies();

        $this->assertArrayHasKey(DoctrineSnowflakeBundle::class, $dependencies);
        $this->assertEquals(['all' => true], $dependencies[DoctrineSnowflakeBundle::class]);
    }

    public function testGetBundleDependencies_containsDoctrineTimestampBundle(): void
    {
        $dependencies = JsonRPCCallerBundle::getBundleDependencies();

        $this->assertArrayHasKey(DoctrineTimestampBundle::class, $dependencies);
        $this->assertEquals(['all' => true], $dependencies[DoctrineTimestampBundle::class]);
    }

    public function testGetBundleDependencies_containsDoctrineTrackBundle(): void
    {
        $dependencies = JsonRPCCallerBundle::getBundleDependencies();

        $this->assertArrayHasKey(DoctrineTrackBundle::class, $dependencies);
        $this->assertEquals(['all' => true], $dependencies[DoctrineTrackBundle::class]);
    }

    public function testGetBundleDependencies_allDependenciesEnabledForAllEnvironments(): void
    {
        $dependencies = JsonRPCCallerBundle::getBundleDependencies();

        foreach ($dependencies as $bundleClass => $config) {
            $this->assertArrayHasKey('all', $config);
            $this->assertTrue($config['all']);
        }
    }

    public function testGetBundleDependencies_isStaticMethod(): void
    {
        $reflection = new \ReflectionMethod(JsonRPCCallerBundle::class, 'getBundleDependencies');
        $this->assertTrue($reflection->isStatic());
        $this->assertTrue($reflection->isPublic());
    }

    public function testDependencyBundleClasses_exist(): void
    {
        $dependencies = JsonRPCCallerBundle::getBundleDependencies();

        foreach (array_keys($dependencies) as $bundleClass) {
            $this->assertTrue(class_exists($bundleClass), "Bundle class {$bundleClass} does not exist");
        }
    }

    public function testDependencyBundleClasses_areSymfonyBundles(): void
    {
        $dependencies = JsonRPCCallerBundle::getBundleDependencies();

        foreach (array_keys($dependencies) as $bundleClass) {
            $bundle = new $bundleClass();
            $this->assertInstanceOf(
                \Symfony\Component\HttpKernel\Bundle\Bundle::class,
                $bundle,
                "Bundle class {$bundleClass} is not a Symfony Bundle"
            );
        }
    }

    public function testBundle_extendsSymfonyBundle(): void
    {
        $this->assertInstanceOf(\Symfony\Component\HttpKernel\Bundle\Bundle::class, $this->bundle);
    }

    public function testBundle_getName_returnsCorrectBundleName(): void
    {
        $expectedName = 'JsonRPCCallerBundle';
        $this->assertEquals($expectedName, $this->bundle->getName());
    }

    public function testBundle_getNamespace_returnsCorrectNamespace(): void
    {
        $expectedNamespace = 'Tourze\JsonRPCCallerBundle';
        $this->assertEquals($expectedNamespace, $this->bundle->getNamespace());
    }

    public function testBundle_getPath_returnsCorrectPath(): void
    {
        $bundlePath = $this->bundle->getPath();
        $this->assertStringEndsWith('src', $bundlePath);
    }
} 