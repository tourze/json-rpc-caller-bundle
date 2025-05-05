<?php

namespace Tourze\JsonRPCCallerBundle\Tests\Integration\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\SchemaTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tourze\JsonRPCCallerBundle\Entity\ApiCaller;
use Tourze\JsonRPCCallerBundle\Repository\ApiCallerRepository;
use Tourze\JsonRPCCallerBundle\Tests\Integration\IntegrationTestKernel;

class ApiCallerRepositoryTest extends KernelTestCase
{
    private ?ApiCallerRepository $repository = null;
    private ?EntityManagerInterface $entityManager = null;

    protected static function getKernelClass(): string
    {
        return IntegrationTestKernel::class;
    }

    protected function setUp(): void
    {
        self::bootKernel();

        $this->entityManager = self::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->entityManager->getRepository(ApiCaller::class);

        // 创建测试数据库 Schema
        $schemaTool = new SchemaTool($this->entityManager);
        $metadata = $this->entityManager->getMetadataFactory()->getAllMetadata();

        // 删除并重建表
        $schemaTool->dropSchema($metadata);
        $schemaTool->createSchema($metadata);

        // 准备测试数据
        $apiCaller = new ApiCaller();
        $apiCaller->setTitle('测试调用方')
            ->setAppId('test-app-id')
            ->setAppSecret('test-app-secret')
            ->setAllowIps(['127.0.0.1'])
            ->setSignTimeoutSecond(300)
            ->setValid(true);

        $this->entityManager->persist($apiCaller);
        $this->entityManager->flush();
    }

    public function testFind_withValidId_returnsApiCaller(): void
    {
        $apiCaller = $this->repository->findOneBy(['appId' => 'test-app-id']);

        $this->assertNotNull($apiCaller);
        $this->assertInstanceOf(ApiCaller::class, $apiCaller);
        $this->assertEquals('test-app-id', $apiCaller->getAppId());
        $this->assertEquals('test-app-secret', $apiCaller->getAppSecret());
        $this->assertEquals('测试调用方', $apiCaller->getTitle());
    }

    public function testFind_withInvalidId_returnsNull(): void
    {
        $apiCaller = $this->repository->findOneBy(['appId' => 'non-existent-app-id']);

        $this->assertNull($apiCaller);
    }

    public function testFindBy_withValidCriteria_returnsMatchingEntities(): void
    {
        $apiCallers = $this->repository->findBy(['valid' => true]);

        $this->assertIsArray($apiCallers);
        $this->assertCount(1, $apiCallers);
        $this->assertEquals('test-app-id', $apiCallers[0]->getAppId());
    }

    public function testFindAll_returnsAllEntities(): void
    {
        $apiCallers = $this->repository->findAll();

        $this->assertIsArray($apiCallers);
        $this->assertCount(1, $apiCallers);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // 清理连接
        if ($this->entityManager) {
            $this->entityManager->close();
            $this->entityManager = null;
        }
    }
}
