<?php

namespace Tourze\JsonRPCCallerBundle\Tests\Entity;

use DateTime;
use PHPUnit\Framework\TestCase;
use Tourze\JsonRPCCallerBundle\Entity\ApiCaller;

class ApiCallerTest extends TestCase
{
    private ApiCaller $apiCaller;

    protected function setUp(): void
    {
        $this->apiCaller = new ApiCaller();
    }

    public function testSetAndGetAppId_withValidData(): void
    {
        $appId = 'test-app-id';
        $this->apiCaller->setAppId($appId);
        $this->assertEquals($appId, $this->apiCaller->getAppId());
    }

    public function testSetAndGetAppSecret_withValidData(): void
    {
        $appSecret = 'test-app-secret';
        $this->apiCaller->setAppSecret($appSecret);
        $this->assertEquals($appSecret, $this->apiCaller->getAppSecret());
    }

    public function testSetAndGetTitle_withValidData(): void
    {
        $title = '测试应用';
        $this->apiCaller->setTitle($title);
        $this->assertEquals($title, $this->apiCaller->getTitle());
    }

    public function testSetAndGetAllowIps_withValidData(): void
    {
        $allowIps = ['127.0.0.1', '192.168.1.1'];
        $this->apiCaller->setAllowIps($allowIps);
        $this->assertEquals($allowIps, $this->apiCaller->getAllowIps());
    }

    public function testSetAndGetSignTimeoutSecond_withValidData(): void
    {
        $timeout = 300;
        $this->apiCaller->setSignTimeoutSecond($timeout);
        $this->assertEquals($timeout, $this->apiCaller->getSignTimeoutSecond());
    }

    public function testSetAndGetAesKey_withValidData(): void
    {
        $aesKey = 'test-aes-key';
        $this->apiCaller->setAesKey($aesKey);
        $this->assertEquals($aesKey, $this->apiCaller->getAesKey());
    }

    public function testSetAndGetRemark_withValidData(): void
    {
        $remark = '测试备注';
        $this->apiCaller->setRemark($remark);
        $this->assertEquals($remark, $this->apiCaller->getRemark());
    }

    public function testSetAndGetValid_withValidData(): void
    {
        $valid = true;
        $this->apiCaller->setValid($valid);
        $this->assertEquals($valid, $this->apiCaller->isValid());
    }

    public function testSetAndGetCreatedBy_withValidData(): void
    {
        $createdBy = 'admin-user';
        $this->apiCaller->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $this->apiCaller->getCreatedBy());
    }

    public function testSetAndGetUpdatedBy_withValidData(): void
    {
        $updatedBy = 'admin-user';
        $this->apiCaller->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $this->apiCaller->getUpdatedBy());
    }

    public function testSetAndGetCreateTime_withValidData(): void
    {
        $createTime = new DateTime('2023-01-01 12:00:00');
        $this->apiCaller->setCreateTime($createTime);
        $this->assertEquals($createTime, $this->apiCaller->getCreateTime());
    }

    public function testSetAndGetUpdateTime_withValidData(): void
    {
        $updateTime = new DateTime('2023-01-02 12:00:00');
        $this->apiCaller->setUpdateTime($updateTime);
        $this->assertEquals($updateTime, $this->apiCaller->getUpdateTime());
    }

    public function testSetAndGetId_returnsNullByDefault(): void
    {
        // ID 默认情况下应为 null（由 Doctrine 自动生成）
        $this->assertNull($this->apiCaller->getId());
    }

    public function testFluentInterface_returnsInstanceOfSelf(): void
    {
        // 测试流式接口 (fluent interface)
        $this->assertInstanceOf(
            ApiCaller::class,
            $this->apiCaller->setAppId('test-app-id')
        );

        $this->assertInstanceOf(
            ApiCaller::class,
            $this->apiCaller->setAppSecret('test-app-secret')
        );

        $this->assertInstanceOf(
            ApiCaller::class,
            $this->apiCaller->setTitle('test-title')
        );
    }
}
