<?php

namespace Tourze\JsonRPCCallerBundle\Tests\Entity\ApiCaller;

use DateTimeImmutable;
use DateTimeInterface;
use PHPUnit\Framework\TestCase;
use Tourze\JsonRPCCallerBundle\Entity\ApiCaller;

/**
 * ApiCaller 实体日期时间测试
 * 测试创建时间和更新时间相关功能
 */
class ApiCallerDateTimeTest extends TestCase
{
    private ApiCaller $apiCaller;

    protected function setUp(): void
    {
        $this->apiCaller = new ApiCaller();
    }

    public function testSetCreateTime_withDateTime_setsCorrectValue(): void
    {
        $dateTime = new DateTimeImmutable('2023-12-01 10:30:45');
        $this->apiCaller->setCreateTime($dateTime);
        
        $this->assertEquals($dateTime, $this->apiCaller->getCreateTime());
        $this->assertInstanceOf(DateTimeInterface::class, $this->apiCaller->getCreateTime());
    }

    public function testSetCreateTime_withDateTimeImmutable_setsCorrectValue(): void
    {
        $dateTime = new DateTimeImmutable('2023-12-01 10:30:45');
        $this->apiCaller->setCreateTime($dateTime);
        
        $this->assertEquals($dateTime, $this->apiCaller->getCreateTime());
        $this->assertInstanceOf(DateTimeInterface::class, $this->apiCaller->getCreateTime());
    }

    public function testSetCreateTime_withNull_setsNull(): void
    {
        $this->apiCaller->setCreateTime(null);
        $this->assertNull($this->apiCaller->getCreateTime());
    }

    public function testSetUpdateTime_withDateTime_setsCorrectValue(): void
    {
        $dateTime = new DateTimeImmutable('2023-12-02 15:45:30');
        $this->apiCaller->setUpdateTime($dateTime);
        
        $this->assertEquals($dateTime, $this->apiCaller->getUpdateTime());
        $this->assertInstanceOf(DateTimeInterface::class, $this->apiCaller->getUpdateTime());
    }

    public function testSetUpdateTime_withDateTimeImmutable_setsCorrectValue(): void
    {
        $dateTime = new DateTimeImmutable('2023-12-02 15:45:30');
        $this->apiCaller->setUpdateTime($dateTime);
        
        $this->assertEquals($dateTime, $this->apiCaller->getUpdateTime());
        $this->assertInstanceOf(DateTimeInterface::class, $this->apiCaller->getUpdateTime());
    }

    public function testSetUpdateTime_withNull_setsNull(): void
    {
        $this->apiCaller->setUpdateTime(null);
        $this->assertNull($this->apiCaller->getUpdateTime());
    }

    public function testDateTime_chronologicalOrder_maintainsConsistency(): void
    {
        $createTime = new DateTimeImmutable('2023-12-01 10:00:00');
        $updateTime = new DateTimeImmutable('2023-12-01 11:00:00');
        
        $this->apiCaller->setCreateTime($createTime);
        $this->apiCaller->setUpdateTime($updateTime);
        
        $this->assertTrue($this->apiCaller->getCreateTime() < $this->apiCaller->getUpdateTime());
    }

    public function testDateTime_sameTimestamp_handledCorrectly(): void
    {
        $timestamp = '2023-12-01 10:30:45';
        $createTime = new DateTimeImmutable($timestamp);
        $updateTime = new DateTimeImmutable($timestamp);
        
        $this->apiCaller->setCreateTime($createTime);
        $this->apiCaller->setUpdateTime($updateTime);
        
        $this->assertEquals($createTime->getTimestamp(), $this->apiCaller->getCreateTime()->getTimestamp());
        $this->assertEquals($updateTime->getTimestamp(), $this->apiCaller->getUpdateTime()->getTimestamp());
        $this->assertEquals(
            $this->apiCaller->getCreateTime()->getTimestamp(),
            $this->apiCaller->getUpdateTime()->getTimestamp()
        );
    }

    public function testDateTime_differentTimezones_handledCorrectly(): void
    {
        $utcTime = new DateTimeImmutable('2023-12-01 10:00:00', new \DateTimeZone('UTC'));
        $beijingTime = new DateTimeImmutable('2023-12-01 18:00:00', new \DateTimeZone('Asia/Shanghai'));
        
        $this->apiCaller->setCreateTime($utcTime);
        $this->apiCaller->setUpdateTime($beijingTime);
        
        // 北京时间18:00等于UTC时间10:00，所以时间戳应该相同
        $this->assertEquals($utcTime->getTimestamp(), $this->apiCaller->getUpdateTime()->getTimestamp());
    }

    public function testDateTime_microseconds_preservedCorrectly(): void
    {
        $dateTimeWithMicroseconds = DateTimeImmutable::createFromFormat('Y-m-d H:i:s.u', '2023-12-01 10:30:45.123456');
        $this->apiCaller->setCreateTime($dateTimeWithMicroseconds);
        
        $retrieved = $this->apiCaller->getCreateTime();
        $this->assertEquals($dateTimeWithMicroseconds->format('Y-m-d H:i:s.u'), $retrieved->format('Y-m-d H:i:s.u'));
    }

    public function testGetCreateTime_defaultValue_returnsNull(): void
    {
        $newCaller = new ApiCaller();
        $this->assertNull($newCaller->getCreateTime());
    }

    public function testGetUpdateTime_defaultValue_returnsNull(): void
    {
        $newCaller = new ApiCaller();
        $this->assertNull($newCaller->getUpdateTime());
    }
} 