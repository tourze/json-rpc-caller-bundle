<?php

namespace Tourze\JsonRPCCallerBundle\Tests\Integration\Bundle;

use Doctrine\Bundle\DoctrineBundle\DoctrineBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tourze\IntegrationTestKernel\IntegrationTestKernel;
use Tourze\JsonRPCCallerBundle\JsonRPCCallerBundle;
use Tourze\JsonRPCCallerBundle\Repository\ApiCallerRepository;

class JsonRPCCallerBundleIntegrationTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return IntegrationTestKernel::class;
    }

    protected static function createKernel(array $options = []): IntegrationTestKernel
    {
        $appendBundles = [
            FrameworkBundle::class => ['all' => true],
            DoctrineBundle::class => ['all' => true],
            JsonRPCCallerBundle::class => ['all' => true],
        ];
        
        $entityMappings = [
            'Tourze\JsonRPCCallerBundle\Entity' => __DIR__ . '/../../../src/Entity',
        ];

        return new IntegrationTestKernel(
            $options['environment'] ?? 'test',
            $options['debug'] ?? true,
            $appendBundles,
            $entityMappings
        );
    }

    public function testServicesWiring_checkRepositoryService(): void
    {
        self::bootKernel();

        $repository = self::getContainer()->get(ApiCallerRepository::class);

        $this->assertInstanceOf(ApiCallerRepository::class, $repository);
    }
}
