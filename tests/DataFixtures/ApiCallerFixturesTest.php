<?php

namespace Tourze\JsonRPCCallerBundle\Tests\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;
use Tourze\JsonRPCCallerBundle\DataFixtures\ApiCallerFixtures;
use Tourze\JsonRPCCallerBundle\Entity\ApiCaller;
use Tourze\JsonRPCCallerBundle\Repository\ApiCallerRepository;
use Tourze\JsonRPCCallerBundle\Tests\Integration\IntegrationTestKernel;

/**
 * ApiCallerFixtures测试类
 */
class ApiCallerFixturesTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private ApiCallerRepository $repository;

    protected static function createKernel(array $options = []): KernelInterface
    {
        return new IntegrationTestKernel('test', true);
    }

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->entityManager->getRepository(ApiCaller::class);
    }

    /**
     * 测试夹具类的基本属性
     */
    public function testFixtureClassProperties(): void
    {
        $fixtures = new ApiCallerFixtures();

        // 测试实现的接口
        $this->assertInstanceOf(Fixture::class, $fixtures);
        $this->assertInstanceOf(FixtureGroupInterface::class, $fixtures);

        // 测试有load方法
        $this->assertTrue(method_exists($fixtures, 'load'));
        
        // 测试有getGroups方法
        $this->assertTrue(method_exists($fixtures, 'getGroups'));
    }

    /**
     * 测试夹具分组
     */
    public function testFixtureGroups(): void
    {
        $groups = ApiCallerFixtures::getGroups();

        $this->assertIsArray($groups);
        $this->assertContains('json-rpc-caller', $groups);
        $this->assertContains('api', $groups);
        $this->assertContains('test', $groups);
        $this->assertCount(3, $groups);
    }

    /**
     * 测试引用常量
     */
    public function testReferenceConstants(): void
    {
        $this->assertEquals('default-api-caller', ApiCallerFixtures::DEFAULT_CALLER_REFERENCE);
        $this->assertEquals('long-timeout-api-caller', ApiCallerFixtures::LONG_TIMEOUT_CALLER_REFERENCE);
        $this->assertEquals('ip-restricted-api-caller', ApiCallerFixtures::IP_RESTRICTED_CALLER_REFERENCE);
        $this->assertEquals('aes-enabled-api-caller', ApiCallerFixtures::AES_ENABLED_CALLER_REFERENCE);
        $this->assertEquals('invalid-api-caller', ApiCallerFixtures::INVALID_CALLER_REFERENCE);
    }

    /**
     * 测试load方法签名
     */
    public function testLoadMethodSignature(): void
    {
        $reflection = new \ReflectionMethod(ApiCallerFixtures::class, 'load');
        
        $this->assertTrue($reflection->isPublic());
        $parameters = $reflection->getParameters();
        $this->assertCount(1, $parameters);
        $this->assertEquals('manager', $parameters[0]->getName());
        $this->assertEquals('Doctrine\Persistence\ObjectManager', $parameters[0]->getType()?->getName());
    }
}
