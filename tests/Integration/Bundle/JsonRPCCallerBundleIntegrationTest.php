<?php

namespace Tourze\JsonRPCCallerBundle\Tests\Integration\Bundle;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Tourze\JsonRPCCallerBundle\Repository\ApiCallerRepository;
use Tourze\JsonRPCCallerBundle\Tests\Integration\IntegrationTestKernel;

class JsonRPCCallerBundleIntegrationTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return IntegrationTestKernel::class;
    }

    public function testServicesWiring_checkRepositoryService(): void
    {
        self::bootKernel();

        $repository = self::getContainer()->get(ApiCallerRepository::class);

        $this->assertInstanceOf(ApiCallerRepository::class, $repository);
    }
}
