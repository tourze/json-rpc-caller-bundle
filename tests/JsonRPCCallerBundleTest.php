<?php

namespace Tourze\JsonRPCCallerBundle\Tests;

use PHPUnit\Framework\TestCase;
use Tourze\JsonRPCCallerBundle\JsonRPCCallerBundle;

class JsonRPCCallerBundleTest extends TestCase
{
    public function testConstruct_returnsInstanceOfBundle(): void
    {
        $bundle = new JsonRPCCallerBundle();
        $this->assertInstanceOf(JsonRPCCallerBundle::class, $bundle);
    }
} 