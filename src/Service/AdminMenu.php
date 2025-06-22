<?php

namespace Tourze\JsonRPCCallerBundle\Service;

use Knp\Menu\ItemInterface;
use Tourze\EasyAdminMenuBundle\Service\LinkGeneratorInterface;
use Tourze\EasyAdminMenuBundle\Service\MenuProviderInterface;
use Tourze\JsonRPCCallerBundle\Entity\ApiCaller;

/**
 * JSON-RPC调用者管理菜单服务
 */
class AdminMenu implements MenuProviderInterface
{
    public function __construct(
        private readonly LinkGeneratorInterface $linkGenerator,
    ) {
    }

    public function __invoke(ItemInterface $item): void
    {
        if ($item->getChild('接口管理') === null) {
            $item->addChild('接口管理');
        }

        $apiMenu = $item->getChild('接口管理');
        
        // API调用者管理菜单
        $apiMenu->addChild('调用者管理')
            ->setUri($this->linkGenerator->getCurdListPage(ApiCaller::class))
            ->setAttribute('icon', 'fas fa-key');
    }
}
