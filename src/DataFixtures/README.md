# JSON-RPC Caller 数据夹具

本目录包含了 JSON-RPC Caller Bundle 的数据夹具，用于初始化测试数据。

## 可用的数据夹具

### ApiCallerFixtures

此夹具创建多个 JSON-RPC 调用者示例，包括：

- **默认调用者**：基本配置，状态有效
- **长超时调用者**：配置了较长的签名超时时间（1小时）
- **IP限制调用者**：配置了IP白名单
- **AES加密调用者**：配置了AES加密密钥
- **无效调用者**：状态被标记为无效

## 使用方法

### 加载夹具

在项目根目录执行：

```bash
php bin/console doctrine:fixtures:load --group=json-rpc-caller
```

如果不希望清空数据库，可以添加 `--append` 选项：

```bash
php bin/console doctrine:fixtures:load --group=json-rpc-caller --append
```

### 在测试中使用引用

所有夹具对象都被注册为引用，可以在依赖的夹具中使用：

```php
use Tourze\JsonRPCCallerBundle\DataFixtures\ApiCallerFixtures;
use Tourze\JsonRPCCallerBundle\Entity\ApiCaller;

// 获取默认调用者引用
$defaultCaller = $this->getReference(ApiCallerFixtures::DEFAULT_CALLER_REFERENCE, ApiCaller::class);

// 获取带AES密钥的调用者引用
$aesEnabledCaller = $this->getReference(ApiCallerFixtures::AES_ENABLED_CALLER_REFERENCE, ApiCaller::class);
```

## 可用引用常量

- `ApiCallerFixtures::DEFAULT_CALLER_REFERENCE` - 默认调用者
- `ApiCallerFixtures::LONG_TIMEOUT_CALLER_REFERENCE` - 长超时调用者
- `ApiCallerFixtures::IP_RESTRICTED_CALLER_REFERENCE` - IP限制调用者
- `ApiCallerFixtures::AES_ENABLED_CALLER_REFERENCE` - AES加密调用者
- `ApiCallerFixtures::INVALID_CALLER_REFERENCE` - 无效调用者

## 注意事项

- 所有随机生成的AppID和AppSecret在每次加载时都会重新生成
- 为了保持一致性，请使用引用常量而不是硬编码引用名称
- 在生产环境中请谨慎使用数据夹具
