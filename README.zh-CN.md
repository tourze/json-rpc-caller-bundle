# JSON-RPC 调用方管理 Bundle

[English](README.md) | [中文](README.zh-CN.md)

[![最新版本](https://img.shields.io/packagist/v/tourze/json-rpc-caller-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/json-rpc-caller-bundle)
[![构建状态](https://img.shields.io/travis/tourze/json-rpc-caller-bundle/master.svg?style=flat-square)](https://travis-ci.org/tourze/json-rpc-caller-bundle)
[![质量评分](https://img.shields.io/scrutinizer/g/tourze/json-rpc-caller-bundle.svg?style=flat-square)](https://scrutinizer-ci.com/g/tourze/json-rpc-caller-bundle)
[![下载量](https://img.shields.io/packagist/dt/tourze/json-rpc-caller-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/json-rpc-caller-bundle)

一个用于管理 JSON-RPC API 调用方的 Symfony Bundle，支持安全的客户端识别、签名验证、IP 白名单等。

## 功能特性

- 管理 JSON-RPC API 调用方（客户端）
- 每个调用方拥有唯一 AppID/AppSecret
- 支持 IP 白名单与 AES 密钥
- 支持签名超时机制
- 提供审计字段，便于安全追踪
- 与 Symfony 和 Doctrine 无缝集成

## 安装说明

### 环境要求

- PHP >= 8.1
- Symfony >= 6.4
- Doctrine DBAL >= 4.0

### Composer 安装

```bash
composer require tourze/json-rpc-caller-bundle
```

## 快速开始

1. 在 Symfony 项目中注册本 Bundle（如未自动发现）。
2. 执行 Doctrine migration，创建 `api_caller` 表。
3. 在数据库中配置你的 JSON-RPC 客户端。

### 使用示例

```php
// 通过 AppID 获取调用方
$caller = $entityManager->getRepository(ApiCaller::class)->findOneBy(['appId' => 'your-app-id']);

// 按需校验签名、IP 等业务逻辑
```

## 数据夹具

本Bundle提供了用于测试和开发环境的数据夹具。可用于快速填充数据库，创建多种类型的API调用者实例。

### 可用夹具

- **ApiCallerFixtures**: 创建5种不同类型的API调用者，涵盖各种配置场景

### 加载夹具

在项目根目录执行：

```bash
php bin/console doctrine:fixtures:load --group=json-rpc-caller
```

如需保留现有数据，可使用`--append`选项：

```bash
php bin/console doctrine:fixtures:load --group=json-rpc-caller --append
```

### 在测试中使用

您可以在测试中使用这些夹具创建的引用：

```php
use Tourze\JsonRPCCallerBundle\DataFixtures\ApiCallerFixtures;
use Tourze\JsonRPCCallerBundle\Entity\ApiCaller;

// 获取默认调用者引用
$defaultCaller = $this->getReference(ApiCallerFixtures::DEFAULT_CALLER_REFERENCE, ApiCaller::class);
```

更多信息，请参阅`src/DataFixtures/README.md`。

## 详细文档

- 实体：`ApiCaller`（详见 ENTITY_DESIGN.md）
- 配置：标准 Symfony Bundle 配置
- 仓库：`ApiCallerRepository`

## 贡献指南

- 通过 GitHub 提交 Issue 或 PR
- 遵循 PSR 代码规范
- 新特性需补充测试

## 协议

MIT License © tourze

## 更新日志

详见 [CHANGELOG.md](CHANGELOG.md)
