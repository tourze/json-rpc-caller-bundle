<?php

namespace Tourze\JsonRPCCallerBundle\Tests\Entity\ApiCaller;

use PHPUnit\Framework\TestCase;
use Tourze\JsonRPCCallerBundle\Entity\ApiCaller;

/**
 * ApiCaller 实体用户字段测试
 * 测试 createdBy 和 updatedBy 字段相关功能
 */
class ApiCallerUserFieldsTest extends TestCase
{
    private ApiCaller $apiCaller;

    protected function setUp(): void
    {
        $this->apiCaller = new ApiCaller();
    }

    public function testSetCreatedBy_withValidUsername_setsCorrectValue(): void
    {
        $username = 'admin_user';
        $this->apiCaller->setCreatedBy($username);
        $this->assertEquals($username, $this->apiCaller->getCreatedBy());
    }

    public function testSetCreatedBy_withEmptyString_setsEmptyValue(): void
    {
        $this->apiCaller->setCreatedBy('');
        $this->assertEquals('', $this->apiCaller->getCreatedBy());
    }

    public function testSetCreatedBy_withNull_setsNull(): void
    {
        $this->apiCaller->setCreatedBy(null);
        $this->assertNull($this->apiCaller->getCreatedBy());
    }

    public function testSetCreatedBy_withSpecialCharacters_setsCorrectValue(): void
    {
        $username = 'user@domain.com';
        $this->apiCaller->setCreatedBy($username);
        $this->assertEquals($username, $this->apiCaller->getCreatedBy());
    }

    public function testSetCreatedBy_withLongUsername_setsCorrectValue(): void
    {
        $longUsername = 'very_long_username_with_many_characters_' . str_repeat('x', 50);
        $this->apiCaller->setCreatedBy($longUsername);
        $this->assertEquals($longUsername, $this->apiCaller->getCreatedBy());
    }

    public function testSetUpdatedBy_withValidUsername_setsCorrectValue(): void
    {
        $username = 'modifier_user';
        $this->apiCaller->setUpdatedBy($username);
        $this->assertEquals($username, $this->apiCaller->getUpdatedBy());
    }

    public function testSetUpdatedBy_withEmptyString_setsEmptyValue(): void
    {
        $this->apiCaller->setUpdatedBy('');
        $this->assertEquals('', $this->apiCaller->getUpdatedBy());
    }

    public function testSetUpdatedBy_withNull_setsNull(): void
    {
        $this->apiCaller->setUpdatedBy(null);
        $this->assertNull($this->apiCaller->getUpdatedBy());
    }

    public function testSetUpdatedBy_withSpecialCharacters_setsCorrectValue(): void
    {
        $username = 'user@domain.com';
        $this->apiCaller->setUpdatedBy($username);
        $this->assertEquals($username, $this->apiCaller->getUpdatedBy());
    }

    public function testSetUpdatedBy_withLongUsername_setsCorrectValue(): void
    {
        $longUsername = 'very_long_modifier_username_' . str_repeat('y', 50);
        $this->apiCaller->setUpdatedBy($longUsername);
        $this->assertEquals($longUsername, $this->apiCaller->getUpdatedBy());
    }

    public function testUserFields_independentValues_maintainSeparately(): void
    {
        $creator = 'creator_user';
        $modifier = 'modifier_user';
        
        $this->apiCaller->setCreatedBy($creator);
        $this->apiCaller->setUpdatedBy($modifier);
        
        $this->assertEquals($creator, $this->apiCaller->getCreatedBy());
        $this->assertEquals($modifier, $this->apiCaller->getUpdatedBy());
        $this->assertNotEquals($this->apiCaller->getCreatedBy(), $this->apiCaller->getUpdatedBy());
    }

    public function testUserFields_sameUser_canCreateAndUpdate(): void
    {
        $username = 'same_user';
        
        $this->apiCaller->setCreatedBy($username);
        $this->apiCaller->setUpdatedBy($username);
        
        $this->assertEquals($username, $this->apiCaller->getCreatedBy());
        $this->assertEquals($username, $this->apiCaller->getUpdatedBy());
        $this->assertEquals($this->apiCaller->getCreatedBy(), $this->apiCaller->getUpdatedBy());
    }

    public function testUserFields_fluentInterface_returnsApiCallerInstance(): void
    {
        $result1 = $this->apiCaller->setCreatedBy('user1');
        $result2 = $this->apiCaller->setUpdatedBy('user2');
        
        $this->assertInstanceOf(ApiCaller::class, $result1);
        $this->assertInstanceOf(ApiCaller::class, $result2);
        $this->assertSame($this->apiCaller, $result1);
        $this->assertSame($this->apiCaller, $result2);
    }

    public function testGetCreatedBy_defaultValue_returnsNull(): void
    {
        $newCaller = new ApiCaller();
        $this->assertNull($newCaller->getCreatedBy());
    }

    public function testGetUpdatedBy_defaultValue_returnsNull(): void
    {
        $newCaller = new ApiCaller();
        $this->assertNull($newCaller->getUpdatedBy());
    }

    public function testUserFields_withNumericUserIds_handledCorrectly(): void
    {
        $numericUserId = '12345';
        
        $this->apiCaller->setCreatedBy($numericUserId);
        $this->apiCaller->setUpdatedBy($numericUserId);
        
        $this->assertEquals($numericUserId, $this->apiCaller->getCreatedBy());
        $this->assertEquals($numericUserId, $this->apiCaller->getUpdatedBy());
    }

    public function testUserFields_withUnicodeCharacters_handledCorrectly(): void
    {
        $unicodeUsername = '用户名_测试';
        
        $this->apiCaller->setCreatedBy($unicodeUsername);
        $this->apiCaller->setUpdatedBy($unicodeUsername);
        
        $this->assertEquals($unicodeUsername, $this->apiCaller->getCreatedBy());
        $this->assertEquals($unicodeUsername, $this->apiCaller->getUpdatedBy());
    }
} 