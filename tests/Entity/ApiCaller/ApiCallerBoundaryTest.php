<?php

namespace Tourze\JsonRPCCallerBundle\Tests\Entity\ApiCaller;

use PHPUnit\Framework\TestCase;
use Tourze\JsonRPCCallerBundle\Entity\ApiCaller;

/**
 * ApiCaller 实体边界值测试
 * 测试字段长度限制、边界值和默认值行为
 */
class ApiCallerBoundaryTest extends TestCase
{
    private ApiCaller $apiCaller;

    protected function setUp(): void
    {
        $this->apiCaller = new ApiCaller();
    }

    public function testSetTitle_withEmptyString_setsEmptyValue(): void
    {
        $this->apiCaller->setTitle('');
        $this->assertEquals('', $this->apiCaller->getTitle());
    }

    public function testSetTitle_withMaxLength_acceptsValue(): void
    {
        // 根据ORM配置，title最大长度为60
        $longTitle = str_repeat('a', 60);
        $this->apiCaller->setTitle($longTitle);
        $this->assertEquals($longTitle, $this->apiCaller->getTitle());
        $this->assertEquals(60, strlen($this->apiCaller->getTitle()));
    }

    public function testSetAppId_withEmptyString_setsEmptyValue(): void
    {
        $this->apiCaller->setAppId('');
        $this->assertEquals('', $this->apiCaller->getAppId());
    }

    public function testSetAppId_withMaxLength_acceptsValue(): void
    {
        // 根据ORM配置，appId最大长度为64
        $longAppId = str_repeat('x', 64);
        $this->apiCaller->setAppId($longAppId);
        $this->assertEquals($longAppId, $this->apiCaller->getAppId());
        $this->assertEquals(64, strlen($this->apiCaller->getAppId()));
    }

    public function testSetAppSecret_withEmptyString_setsEmptyValue(): void
    {
        $this->apiCaller->setAppSecret('');
        $this->assertEquals('', $this->apiCaller->getAppSecret());
    }

    public function testSetAppSecret_withMaxLength_acceptsValue(): void
    {
        // 根据ORM配置，appSecret最大长度为120
        $longSecret = str_repeat('s', 120);
        $this->apiCaller->setAppSecret($longSecret);
        $this->assertEquals($longSecret, $this->apiCaller->getAppSecret());
        $this->assertEquals(120, strlen($this->apiCaller->getAppSecret()));
    }

    public function testSetSignTimeoutSecond_withZero_setsZeroValue(): void
    {
        $this->apiCaller->setSignTimeoutSecond(0);
        $this->assertEquals(0, $this->apiCaller->getSignTimeoutSecond());
    }

    public function testSetSignTimeoutSecond_withNegativeValue_setsNegativeValue(): void
    {
        $this->apiCaller->setSignTimeoutSecond(-100);
        $this->assertEquals(-100, $this->apiCaller->getSignTimeoutSecond());
    }

    public function testSetSignTimeoutSecond_withLargeValue_setsLargeValue(): void
    {
        $largeValue = PHP_INT_MAX;
        $this->apiCaller->setSignTimeoutSecond($largeValue);
        $this->assertEquals($largeValue, $this->apiCaller->getSignTimeoutSecond());
    }

    public function testDefaultValues_newInstance_hasCorrectDefaults(): void
    {
        $newCaller = new ApiCaller();
        
        // 根据实体注解，默认值应该是这些
        $this->assertNull($newCaller->getId());
        $this->assertNull($newCaller->getAppSecret());
        $this->assertEquals([], $newCaller->getAllowIps());
        $this->assertEquals(180, $newCaller->getSignTimeoutSecond());
        $this->assertNull($newCaller->getAesKey());
        $this->assertNull($newCaller->getRemark());
        $this->assertFalse($newCaller->isValid());
        $this->assertNull($newCaller->getCreatedBy());
        $this->assertNull($newCaller->getUpdatedBy());
        $this->assertNull($newCaller->getCreateTime());
        $this->assertNull($newCaller->getUpdateTime());
    }

    public function testSetAllowIps_withEmptyArray_setsEmptyArray(): void
    {
        $this->apiCaller->setAllowIps([]);
        $this->assertEquals([], $this->apiCaller->getAllowIps());
    }

    public function testSetAllowIps_withSingleIp_setsSingleIpArray(): void
    {
        $singleIp = ['192.168.1.1'];
        $this->apiCaller->setAllowIps($singleIp);
        $this->assertEquals($singleIp, $this->apiCaller->getAllowIps());
    }

    public function testSetAllowIps_withMultipleIps_setsMultipleIpsArray(): void
    {
        $multipleIps = ['127.0.0.1', '192.168.1.1', '10.0.0.1', '172.16.0.1'];
        $this->apiCaller->setAllowIps($multipleIps);
        $this->assertEquals($multipleIps, $this->apiCaller->getAllowIps());
        $this->assertCount(4, $this->apiCaller->getAllowIps());
    }

    public function testSetAllowIps_withNull_setsNull(): void
    {
        $this->apiCaller->setAllowIps(null);
        $this->assertNull($this->apiCaller->getAllowIps());
    }

    public function testSetValid_withNull_setsNull(): void
    {
        $this->apiCaller->setValid(null);
        $this->assertNull($this->apiCaller->isValid());
    }

    public function testSetAesKey_withNull_setsNull(): void
    {
        $this->apiCaller->setAesKey(null);
        $this->assertNull($this->apiCaller->getAesKey());
    }

    public function testSetRemark_withNull_setsNull(): void
    {
        $this->apiCaller->setRemark(null);
        $this->assertNull($this->apiCaller->getRemark());
    }

    public function testSetSignTimeoutSecond_withNull_setsNull(): void
    {
        $this->apiCaller->setSignTimeoutSecond(null);
        $this->assertNull($this->apiCaller->getSignTimeoutSecond());
    }
} 