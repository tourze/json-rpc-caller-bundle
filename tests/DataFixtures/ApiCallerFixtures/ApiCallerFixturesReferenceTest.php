<?php

namespace Tourze\JsonRPCCallerBundle\Tests\DataFixtures\ApiCallerFixtures;

use PHPUnit\Framework\TestCase;
use Tourze\JsonRPCCallerBundle\DataFixtures\ApiCallerFixtures;

/**
 * ApiCallerFixtures 引用测试
 * 测试所有引用常量的有效性和一致性
 */
class ApiCallerFixturesReferenceTest extends TestCase
{
    private ApiCallerFixtures $fixtures;

    protected function setUp(): void
    {
        $this->fixtures = new ApiCallerFixtures();
    }

    public function testReferenceConstants_exist(): void
    {
        $reflection = new \ReflectionClass(ApiCallerFixtures::class);
        
        $this->assertTrue($reflection->hasConstant('DEFAULT_CALLER_REFERENCE'));
        $this->assertTrue($reflection->hasConstant('LONG_TIMEOUT_CALLER_REFERENCE'));
        $this->assertTrue($reflection->hasConstant('IP_RESTRICTED_CALLER_REFERENCE'));
        $this->assertTrue($reflection->hasConstant('AES_ENABLED_CALLER_REFERENCE'));
        $this->assertTrue($reflection->hasConstant('INVALID_CALLER_REFERENCE'));
    }

    public function testReferenceConstants_haveCorrectValues(): void
    {
        $this->assertEquals('default-api-caller', ApiCallerFixtures::DEFAULT_CALLER_REFERENCE);
        $this->assertEquals('long-timeout-api-caller', ApiCallerFixtures::LONG_TIMEOUT_CALLER_REFERENCE);
        $this->assertEquals('ip-restricted-api-caller', ApiCallerFixtures::IP_RESTRICTED_CALLER_REFERENCE);
        $this->assertEquals('aes-enabled-api-caller', ApiCallerFixtures::AES_ENABLED_CALLER_REFERENCE);
        $this->assertEquals('invalid-api-caller', ApiCallerFixtures::INVALID_CALLER_REFERENCE);
    }

    public function testReferenceConstants_areUnique(): void
    {
        $references = [
            ApiCallerFixtures::DEFAULT_CALLER_REFERENCE,
            ApiCallerFixtures::LONG_TIMEOUT_CALLER_REFERENCE,
            ApiCallerFixtures::IP_RESTRICTED_CALLER_REFERENCE,
            ApiCallerFixtures::AES_ENABLED_CALLER_REFERENCE,
            ApiCallerFixtures::INVALID_CALLER_REFERENCE,
        ];
        
        $uniqueReferences = array_unique($references);
        $this->assertCount(count($references), $uniqueReferences, 'Reference constants must be unique');
    }

    public function testReferenceConstants_followNamingConvention(): void
    {
        $references = [
            ApiCallerFixtures::DEFAULT_CALLER_REFERENCE,
            ApiCallerFixtures::LONG_TIMEOUT_CALLER_REFERENCE,
            ApiCallerFixtures::IP_RESTRICTED_CALLER_REFERENCE,
            ApiCallerFixtures::AES_ENABLED_CALLER_REFERENCE,
            ApiCallerFixtures::INVALID_CALLER_REFERENCE,
        ];
        
        foreach ($references as $reference) {
            $this->assertIsString($reference);
            $this->assertStringEndsWith('-api-caller', $reference);
            $this->assertStringNotContainsString(' ', $reference, 'Reference should not contain spaces');
            $this->assertStringNotContainsString('_', $reference, 'Reference should use hyphens, not underscores');
        }
    }

    public function testReferenceConstants_arePublic(): void
    {
        $reflection = new \ReflectionClass(ApiCallerFixtures::class);
        
        $constants = [
            'DEFAULT_CALLER_REFERENCE',
            'LONG_TIMEOUT_CALLER_REFERENCE', 
            'IP_RESTRICTED_CALLER_REFERENCE',
            'AES_ENABLED_CALLER_REFERENCE',
            'INVALID_CALLER_REFERENCE',
        ];
        
        foreach ($constants as $constantName) {
            $constant = $reflection->getReflectionConstant($constantName);
            $this->assertTrue($constant->isPublic(), "Constant {$constantName} should be public");
        }
    }

    public function testGetGroups_returnsCorrectGroups(): void
    {
        $groups = ApiCallerFixtures::getGroups();
        
        $this->assertIsArray($groups);
        $this->assertContains('json-rpc-caller', $groups);
        $this->assertContains('api', $groups);
        $this->assertContains('test', $groups);
    }

    public function testGetGroups_groupsAreUnique(): void
    {
        $groups = ApiCallerFixtures::getGroups();
        $uniqueGroups = array_unique($groups);
        
        $this->assertCount(count($groups), $uniqueGroups, 'Groups should be unique');
    }

    public function testGetGroups_isStaticMethod(): void
    {
        $reflection = new \ReflectionMethod(ApiCallerFixtures::class, 'getGroups');
        $this->assertTrue($reflection->isStatic());
        $this->assertTrue($reflection->isPublic());
    }

    public function testFixtures_implementsCorrectInterfaces(): void
    {
        $this->assertInstanceOf(\Doctrine\Bundle\FixturesBundle\Fixture::class, $this->fixtures);
        $this->assertInstanceOf(\Doctrine\Bundle\FixturesBundle\FixtureGroupInterface::class, $this->fixtures);
    }

    public function testFixtures_hasLoadMethod(): void
    {
        $this->assertTrue(method_exists($this->fixtures, 'load'));
        
        $reflection = new \ReflectionMethod($this->fixtures, 'load');
        $this->assertTrue($reflection->isPublic());
        
        $parameters = $reflection->getParameters();
        $this->assertCount(1, $parameters);
        $this->assertEquals('manager', $parameters[0]->getName());
    }

    public function testFixtures_classIsInCorrectNamespace(): void
    {
        $reflection = new \ReflectionClass(ApiCallerFixtures::class);
        $this->assertEquals('Tourze\JsonRPCCallerBundle\DataFixtures', $reflection->getNamespaceName());
    }

    public function testFixtures_hasCorrectClassName(): void
    {
        $reflection = new \ReflectionClass(ApiCallerFixtures::class);
        $this->assertEquals('ApiCallerFixtures', $reflection->getShortName());
    }

    public function testFixtures_hasDocBlock(): void
    {
        $reflection = new \ReflectionClass(ApiCallerFixtures::class);
        $docComment = $reflection->getDocComment();
        
        $this->assertIsString($docComment);
        $this->assertStringContainsString('ApiCaller', $docComment);
        $this->assertStringContainsString('数据夹具', $docComment);
    }
} 