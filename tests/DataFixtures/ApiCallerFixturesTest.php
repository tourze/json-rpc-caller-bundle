<?php

namespace Tourze\JsonRPCCallerBundle\Tests\DataFixtures;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tourze\JsonRPCCallerBundle\DataFixtures\ApiCallerFixtures;
use Tourze\JsonRPCCallerBundle\Entity\ApiCaller;
use Tourze\JsonRPCCallerBundle\Repository\ApiCallerRepository;

/**
 * ApiCallerFixtures测试类
 */
class ApiCallerFixturesTest extends KernelTestCase
{
    private EntityManagerInterface $entityManager;
    private ApiCallerRepository $repository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->entityManager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->entityManager->getRepository(ApiCaller::class);

        // 清理现有数据
        $this->clearData();
    }

    protected function tearDown(): void
    {
        // 清理测试数据
        $this->clearData();

        parent::tearDown();
    }

    /**
     * 清理测试数据
     */
    private function clearData(): void
    {
        $callers = $this->repository->findAll();
        foreach ($callers as $caller) {
            $this->entityManager->remove($caller);
        }
        $this->entityManager->flush();
    }

    /**
     * 测试加载数据夹具
     */
    public function testLoadFixtures(): void
    {
        // 创建一个新的夹具实例
        $fixtures = new ApiCallerFixtures();

        // 加载夹具
        $fixtures->load($this->entityManager);

        // 验证夹具加载结果
        $callers = $this->repository->findAll();

        // 应该创建了5个调用者
        $this->assertCount(5, $callers);

        // 检查默认调用者
        $defaultCaller = $this->repository->findOneBy(['title' => '默认调用者']);
        $this->assertNotNull($defaultCaller);
        $this->assertTrue($defaultCaller->isValid());
        $this->assertEquals(180, $defaultCaller->getSignTimeoutSecond());

        // 检查长超时调用者
        $longTimeoutCaller = $this->repository->findOneBy(['title' => '长超时调用者']);
        $this->assertNotNull($longTimeoutCaller);
        $this->assertEquals(3600, $longTimeoutCaller->getSignTimeoutSecond());

        // 检查IP限制调用者
        $ipRestrictedCaller = $this->repository->findOneBy(['title' => 'IP限制调用者']);
        $this->assertNotNull($ipRestrictedCaller);
        $this->assertCount(3, $ipRestrictedCaller->getAllowIps());
        $this->assertContains('127.0.0.1', $ipRestrictedCaller->getAllowIps());

        // 检查AES加密调用者
        $aesEnabledCaller = $this->repository->findOneBy(['title' => 'AES加密调用者']);
        $this->assertNotNull($aesEnabledCaller);
        $this->assertNotNull($aesEnabledCaller->getAesKey());

        // 检查无效调用者
        $invalidCaller = $this->repository->findOneBy(['title' => '无效调用者']);
        $this->assertNotNull($invalidCaller);
        $this->assertFalse($invalidCaller->isValid());
    }

    /**
     * 测试夹具分组
     */
    public function testFixtureGroups(): void
    {
        $fixtures = new ApiCallerFixtures();
        $groups = $fixtures::getGroups();

        $this->assertIsArray($groups);
        $this->assertContains('json-rpc-caller', $groups);
        $this->assertContains('api', $groups);
        $this->assertContains('test', $groups);
    }
}
