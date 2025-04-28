# Entity Design: ApiCaller

## Entity: ApiCaller

- **id**: string (bigint, 雪花ID)
- **title**: string (名称，唯一)
- **appId**: string (AppID，唯一)
- **appSecret**: string (AppSecret)
- **allowIps**: array (允许调用的IP)
- **signTimeoutSecond**: int (签名超时时间，默认180秒)
- **aesKey**: string (AES Key)
- **remark**: string (备注)
- **createdAt**: datetime (创建时间)
- **updatedAt**: datetime (更新时间)
- **createdBy**: string (创建人)
- **updatedBy**: string (更新人)

### 设计说明

- 该实体用于管理允许调用 JSON-RPC 服务的客户端信息。
- 支持唯一标识、权限控制、IP 白名单、签名超时等安全机制。
- 采用雪花ID生成主键，适合分布式环境。
- 关联了创建/更新时间及操作用户，便于审计。

---

# Entity 设计: ApiCaller

## 实体: ApiCaller

- **id**: string (bigint, 雪花ID)
- **title**: string (名称，唯一)
- **appId**: string (AppID，唯一)
- **appSecret**: string (AppSecret)
- **allowIps**: array (允许调用的IP)
- **signTimeoutSecond**: int (签名超时时间，默认180秒)
- **aesKey**: string (AES Key)
- **remark**: string (备注)
- **createdAt**: datetime (创建时间)
- **updatedAt**: datetime (更新时间)
- **createdBy**: string (创建人)
- **updatedBy**: string (更新人)

### 设计说明

- 用于管理 JSON-RPC 客户端信息。
- 支持唯一标识、权限控制、IP 白名单、签名超时等安全机制。
- 雪花ID，适合分布式。
- 具备审计字段。
