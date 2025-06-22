<?php

namespace Tourze\JsonRPCCallerBundle\Tests\Repository\ApiCallerRepository;

use PHPUnit\Framework\TestCase;
use Tourze\JsonRPCCallerBundle\Repository\ApiCallerRepository;

/**
 * ApiCallerRepository 查询功能测试
 * 测试Repository类的基本结构和方法签名
 */
class ApiCallerRepositoryQueryTest extends TestCase
{
    public function testRepository_extendsServiceEntityRepository(): void
    {
        // Repository 类应该继承自 ServiceEntityRepository
        $reflection = new \ReflectionClass(ApiCallerRepository::class);
        $parent = $reflection->getParentClass();
        $this->assertNotFalse($parent);
        $this->assertEquals(\Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository::class, $parent->getName());
    }

    public function testRepository_hasCorrectMethods(): void
    {
        $methods = get_class_methods(ApiCallerRepository::class);
        
        $this->assertContains('find', $methods);
        $this->assertContains('findOneBy', $methods);
        $this->assertContains('findAll', $methods);
        $this->assertContains('findBy', $methods);
    }

    public function testConstructor_hasCorrectSignature(): void
    {
        $reflection = new \ReflectionClass(ApiCallerRepository::class);
        $constructor = $reflection->getConstructor();
        
        $this->assertNotNull($constructor);
        $parameters = $constructor->getParameters();
        $this->assertCount(1, $parameters);
        $this->assertEquals('registry', $parameters[0]->getName());
        $type = $parameters[0]->getType();
        $this->assertNotNull($type);
        // 使用 __toString() 方法获取类型名称
        $this->assertEquals('Doctrine\Persistence\ManagerRegistry', (string) $type);
    }

    public function testRepository_implementsCorrectInterfaces(): void
    {
        $reflection = new \ReflectionClass(ApiCallerRepository::class);
        $interfaces = $reflection->getInterfaceNames();
        
        $this->assertContains(\Doctrine\Persistence\ObjectRepository::class, $interfaces);
        $this->assertContains(\Doctrine\Common\Collections\Selectable::class, $interfaces);
    }

    public function testClassDocBlocks_haveCorrectAnnotations(): void
    {
        $reflection = new \ReflectionClass(ApiCallerRepository::class);
        $docComment = $reflection->getDocComment();
        
        $this->assertIsString($docComment);
        $this->assertStringContainsString('@method ApiCaller|null find(', $docComment);
        $this->assertStringContainsString('@method ApiCaller|null findOneBy(', $docComment);
        $this->assertStringContainsString('@method ApiCaller[]    findAll(', $docComment);
        $this->assertStringContainsString('@method ApiCaller[]    findBy(', $docComment);
    }

    public function testRepository_usesCorrectEntityClass(): void
    {
        $reflection = new \ReflectionClass(ApiCallerRepository::class);
        $docComment = $reflection->getDocComment();
        
        // 检查文档注释中是否正确引用了ApiCaller实体
        $this->assertStringContainsString('ApiCaller', $docComment);
    }

    public function testMethodSignatures_followDoctrineConventions(): void
    {
        $reflection = new \ReflectionClass(ApiCallerRepository::class);
        
        // 检查find方法签名
        $this->assertTrue($reflection->hasMethod('find'));
        $findMethod = $reflection->getMethod('find');
        $this->assertTrue($findMethod->isPublic());
        
        // 检查findOneBy方法签名
        $this->assertTrue($reflection->hasMethod('findOneBy'));
        $findOneByMethod = $reflection->getMethod('findOneBy');
        $this->assertTrue($findOneByMethod->isPublic());
        
        // 检查findAll方法签名
        $this->assertTrue($reflection->hasMethod('findAll'));
        $findAllMethod = $reflection->getMethod('findAll');
        $this->assertTrue($findAllMethod->isPublic());
        
        // 检查findBy方法签名
        $this->assertTrue($reflection->hasMethod('findBy'));
        $findByMethod = $reflection->getMethod('findBy');
        $this->assertTrue($findByMethod->isPublic());
    }

    public function testRepository_classExists(): void
    {
        $this->assertTrue(class_exists(ApiCallerRepository::class));
    }

    public function testRepository_isInCorrectNamespace(): void
    {
        $reflection = new \ReflectionClass(ApiCallerRepository::class);
        $this->assertEquals('Tourze\JsonRPCCallerBundle\Repository', $reflection->getNamespaceName());
    }

    public function testRepository_hasCorrectClassName(): void
    {
        $reflection = new \ReflectionClass(ApiCallerRepository::class);
        $this->assertEquals('ApiCallerRepository', $reflection->getShortName());
    }
} 