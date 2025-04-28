# JSON-RPC Caller Bundle

[English](README.md) | [中文](README.zh-CN.md)

[![Latest Version](https://img.shields.io/packagist/v/tourze/json-rpc-caller-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/json-rpc-caller-bundle)
[![Build Status](https://img.shields.io/travis/tourze/json-rpc-caller-bundle/master.svg?style=flat-square)](https://travis-ci.org/tourze/json-rpc-caller-bundle)
[![Quality Score](https://img.shields.io/scrutinizer/g/tourze/json-rpc-caller-bundle.svg?style=flat-square)](https://scrutinizer-ci.com/g/tourze/json-rpc-caller-bundle)
[![Total Downloads](https://img.shields.io/packagist/dt/tourze/json-rpc-caller-bundle.svg?style=flat-square)](https://packagist.org/packages/tourze/json-rpc-caller-bundle)

A Symfony bundle for managing JSON-RPC API callers, supporting secure client identification, signature verification, IP whitelist, and more.

## Features

- Manage JSON-RPC API callers (clients)
- Unique AppID/AppSecret for each caller
- IP whitelist and AES key support
- Signature timeout mechanism
- Audit fields for security and traceability
- Easy integration with Symfony and Doctrine

## Installation

### Requirements

- PHP >= 8.1
- Symfony >= 6.4
- Doctrine DBAL >= 4.0

### Composer

```bash
composer require tourze/json-rpc-caller-bundle
```

## Quick Start

1. Register the bundle in your Symfony application (if not auto-discovered).
2. Run Doctrine migrations to create the `api_caller` table.
3. Configure your JSON-RPC clients in the database.

### Example Usage

```php
// Fetch a caller by AppID
$caller = $entityManager->getRepository(ApiCaller::class)->findOneBy(['appId' => 'your-app-id']);

// Validate signature, IP, etc. according to your business logic
```

## Documentation

- Entity: `ApiCaller` (see ENTITY_DESIGN.md)
- Configuration: Standard Symfony bundle config
- Repository: `ApiCallerRepository`

## Contribution

- Submit issues or pull requests via GitHub
- Follow PSR coding standards
- Add tests for new features

## License

MIT License © tourze

## Changelog

See [CHANGELOG.md](CHANGELOG.md) for details.
