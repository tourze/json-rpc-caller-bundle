<?php

namespace Tourze\JsonRPCCallerBundle\Test\Service;

use Knp\Menu\ItemInterface;
use PHPUnit\Framework\TestCase;
use Tourze\EasyAdminMenuBundle\Service\LinkGeneratorInterface;
use Tourze\JsonRPCCallerBundle\Entity\ApiCaller;
use Tourze\JsonRPCCallerBundle\Service\AdminMenu;

class AdminMenuTest extends TestCase
{
    private AdminMenu $adminMenu;
    private LinkGeneratorInterface $linkGenerator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->linkGenerator = $this->createMock(LinkGeneratorInterface::class);
        $this->adminMenu = new AdminMenu($this->linkGenerator);
    }

    public function testInvokeAddsApiCallerMenu(): void
    {
        $mainItem = $this->createMock(ItemInterface::class);
        $apiItem = $this->createMock(ItemInterface::class);
        $menuItem = $this->createMock(ItemInterface::class);

        // 第一次调用 getChild 返回 null，第二次返回已创建的菜单项
        $mainItem->expects($this->exactly(2))
            ->method('getChild')
            ->with('接口管理')
            ->willReturnOnConsecutiveCalls(null, $apiItem);

        // 创建接口管理父菜单
        $mainItem->expects($this->once())
            ->method('addChild')
            ->with('接口管理')
            ->willReturn($apiItem);

        // 配置链接生成器
        $this->linkGenerator->expects($this->once())
            ->method('getCurdListPage')
            ->with(ApiCaller::class)
            ->willReturn('/admin/json-rpc-caller/api-caller');

        // 添加调用者管理子菜单
        $apiItem->expects($this->once())
            ->method('addChild')
            ->with('调用者管理')
            ->willReturn($menuItem);

        // 设置URI
        $menuItem->expects($this->once())
            ->method('setUri')
            ->with('/admin/json-rpc-caller/api-caller')
            ->willReturn($menuItem);

        // 设置图标
        $menuItem->expects($this->once())
            ->method('setAttribute')
            ->with('icon', 'fas fa-key')
            ->willReturn($menuItem);

        ($this->adminMenu)($mainItem);
    }

    public function testInvokeWithExistingApiMenu(): void
    {
        $mainItem = $this->createMock(ItemInterface::class);
        $apiItem = $this->createMock(ItemInterface::class);
        $menuItem = $this->createMock(ItemInterface::class);

        // 接口管理菜单已存在
        $mainItem->expects($this->exactly(2))
            ->method('getChild')
            ->with('接口管理')
            ->willReturn($apiItem);

        // 不应该再次创建
        $mainItem->expects($this->never())
            ->method('addChild');

        // 配置链接生成器
        $this->linkGenerator->expects($this->once())
            ->method('getCurdListPage')
            ->with(ApiCaller::class)
            ->willReturn('/admin/json-rpc-caller/api-caller');

        // 添加调用者管理子菜单
        $apiItem->expects($this->once())
            ->method('addChild')
            ->with('调用者管理')
            ->willReturn($menuItem);

        // 设置URI和图标
        $menuItem->expects($this->once())
            ->method('setUri')
            ->with('/admin/json-rpc-caller/api-caller')
            ->willReturn($menuItem);

        $menuItem->expects($this->once())
            ->method('setAttribute')
            ->with('icon', 'fas fa-key')
            ->willReturn($menuItem);

        ($this->adminMenu)($mainItem);
    }
}