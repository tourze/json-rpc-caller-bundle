<?php

namespace Tourze\JsonRPCCallerBundle\Test\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use PHPUnit\Framework\TestCase;
use Tourze\JsonRPCCallerBundle\Controller\Admin\ApiCallerCrudController;
use Tourze\JsonRPCCallerBundle\Entity\ApiCaller;

class ApiCallerCrudControllerTest extends TestCase
{
    private ApiCallerCrudController $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new ApiCallerCrudController();
    }

    public function testGetEntityFqcn(): void
    {
        $this->assertSame(ApiCaller::class, ApiCallerCrudController::getEntityFqcn());
    }

    public function testConfigureCrud(): void
    {
        $crud = $this->createMock(Crud::class);
        
        $crud->expects($this->once())
            ->method('setEntityLabelInSingular')
            ->with('API调用者')
            ->willReturn($crud);
            
        $crud->expects($this->once())
            ->method('setEntityLabelInPlural')
            ->with('API调用者')
            ->willReturn($crud);
            
        $crud->expects($this->exactly(4))
            ->method('setPageTitle')
            ->willReturn($crud);
            
        $crud->expects($this->once())
            ->method('setHelp')
            ->with('index', '管理系统中的API调用者配置，包括签名验证、IP白名单等安全设置')
            ->willReturn($crud);
            
        $crud->expects($this->once())
            ->method('setDefaultSort')
            ->with(['id' => 'DESC'])
            ->willReturn($crud);
            
        $crud->expects($this->once())
            ->method('setSearchFields')
            ->with(['id', 'title', 'appId'])
            ->willReturn($crud);

        $result = $this->controller->configureCrud($crud);
        $this->assertSame($crud, $result);
    }

    public function testConfigureFields(): void
    {
        $fields = iterator_to_array($this->controller->configureFields(Crud::PAGE_INDEX));
        
        $expectedFields = [
            'id',
            'title',
            'appId',
            'appSecret',
            'allowIps',
            'signTimeoutSecond',
            'aesKey',
            'remark',
            'valid',
            'createdBy',
            'updatedBy',
            'createTime',
            'updateTime'
        ];
        
        $this->assertCount(count($expectedFields), $fields);
        
        foreach ($fields as $index => $field) {
            $this->assertSame($expectedFields[$index], $field->getAsDto()->getProperty());
        }
    }
}