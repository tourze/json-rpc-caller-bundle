<?php

namespace Tourze\JsonRPCCallerBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Tourze\DoctrineIndexedBundle\Attribute\IndexColumn;
use Tourze\DoctrineSnowflakeBundle\Service\SnowflakeIdGenerator;
use Tourze\DoctrineTimestampBundle\Attribute\CreateTimeColumn;
use Tourze\DoctrineTimestampBundle\Attribute\UpdateTimeColumn;
use Tourze\DoctrineTrackBundle\Attribute\TrackColumn;
use Tourze\DoctrineUserBundle\Attribute\CreatedByColumn;
use Tourze\DoctrineUserBundle\Attribute\UpdatedByColumn;
use Tourze\EasyAdmin\Attribute\Action\Creatable;
use Tourze\EasyAdmin\Attribute\Action\Deletable;
use Tourze\EasyAdmin\Attribute\Action\Editable;
use Tourze\EasyAdmin\Attribute\Column\BoolColumn;
use Tourze\EasyAdmin\Attribute\Column\ExportColumn;
use Tourze\EasyAdmin\Attribute\Column\ListColumn;
use Tourze\EasyAdmin\Attribute\Field\FormField;
use Tourze\EasyAdmin\Attribute\Filter\Filterable;
use Tourze\EasyAdmin\Attribute\Filter\Keyword;
use Tourze\EasyAdmin\Attribute\Permission\AsPermission;
use Tourze\JsonRPCCallerBundle\Repository\ApiCallerRepository;

/**
 * 主要用来识别接口调用方，目前只有签名业务用到
 *
 * @see https://happypeter.github.io/binfo/aes
 */
#[IsGranted('ROLE_ADMIN')]
#[AsPermission(title: 'API调用者')]
#[Creatable]
#[Editable]
#[Deletable]
#[ORM\Entity(repositoryClass: ApiCallerRepository::class)]
#[ORM\Table(name: 'api_caller', options: ['comment' => 'API调用者'])]
class ApiCaller
{
    #[ExportColumn]
    #[ListColumn(order: -1, sorter: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(SnowflakeIdGenerator::class)]
    #[ORM\Column(type: Types::BIGINT, nullable: false, options: ['comment' => 'ID'])]
    private ?string $id = null;

    #[Keyword]
    #[ListColumn]
    #[FormField]
    #[ORM\Column(type: Types::STRING, length: 60, unique: true, options: ['comment' => '名称'])]
    private string $title;

    #[Keyword]
    #[ListColumn]
    #[FormField(span: 12)]
    #[ORM\Column(type: Types::STRING, length: 64, unique: true, nullable: false, options: ['comment' => 'AppID'])]
    private string $appId;

    #[Keyword]
    #[ListColumn]
    #[FormField(span: 12)]
    #[ORM\Column(type: Types::STRING, length: 120, options: ['comment' => 'AppSecret'])]
    private ?string $appSecret = null;

    #[ListColumn]
    #[FormField]
    #[ORM\Column(type: Types::JSON, nullable: true, options: ['comment' => '允许调用IP'])]
    private ?array $allowIps = [];

    #[ListColumn]
    #[FormField]
    #[ORM\Column(type: Types::INTEGER, nullable: true, options: ['comment' => '签名超时时间', 'default' => 180])]
    private ?int $signTimeoutSecond = 180;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['comment' => 'AES Key'])]
    private ?string $aesKey = null;

    #[FormField]
    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['comment' => '备注', 'default' => ''])]
    private ?string $remark = null;

    #[BoolColumn]
    #[IndexColumn]
    #[TrackColumn]
    #[ORM\Column(type: Types::BOOLEAN, nullable: true, options: ['comment' => '有效', 'default' => 0])]
    #[ListColumn(order: 97)]
    #[FormField(order: 97)]
    private ?bool $valid = false;

    #[CreatedByColumn]
    #[ORM\Column(nullable: true, options: ['comment' => '创建人'])]
    private ?string $createdBy = null;

    #[UpdatedByColumn]
    #[ORM\Column(nullable: true, options: ['comment' => '更新人'])]
    private ?string $updatedBy = null;

    #[Filterable]
    #[IndexColumn]
    #[ListColumn(order: 98, sorter: true)]
    #[ExportColumn]
    #[CreateTimeColumn]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['comment' => '创建时间'])]
    private ?\DateTimeInterface $createTime = null;

    #[UpdateTimeColumn]
    #[ListColumn(order: 99, sorter: true)]
    #[Filterable]
    #[ExportColumn]
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true, options: ['comment' => '更新时间'])]
    private ?\DateTimeInterface $updateTime = null;

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getAppId(): string
    {
        return $this->appId;
    }

    public function setAppId(string $appId): self
    {
        $this->appId = $appId;

        return $this;
    }

    public function getAppSecret(): ?string
    {
        return $this->appSecret;
    }

    public function setAppSecret(string $appSecret): self
    {
        $this->appSecret = $appSecret;

        return $this;
    }

    public function getAllowIps(): ?array
    {
        return $this->allowIps;
    }

    public function setAllowIps(?array $allowIps): self
    {
        $this->allowIps = $allowIps;

        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSignTimeoutSecond(): ?int
    {
        return $this->signTimeoutSecond;
    }

    public function setSignTimeoutSecond(?int $signTimeoutSecond): self
    {
        $this->signTimeoutSecond = $signTimeoutSecond;

        return $this;
    }

    public function getAesKey(): ?string
    {
        return $this->aesKey;
    }

    public function setAesKey(?string $aesKey): self
    {
        $this->aesKey = $aesKey;

        return $this;
    }

    public function getRemark(): ?string
    {
        return $this->remark;
    }

    public function setRemark(?string $remark): self
    {
        $this->remark = $remark;

        return $this;
    }

    public function isValid(): ?bool
    {
        return $this->valid;
    }

    public function setValid(?bool $valid): self
    {
        $this->valid = $valid;

        return $this;
    }

    public function setCreatedBy(?string $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setUpdatedBy(?string $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }

    public function setCreateTime(?\DateTimeInterface $createdAt): void
    {
        $this->createTime = $createdAt;
    }

    public function getCreateTime(): ?\DateTimeInterface
    {
        return $this->createTime;
    }

    public function setUpdateTime(?\DateTimeInterface $updateTime): void
    {
        $this->updateTime = $updateTime;
    }

    public function getUpdateTime(): ?\DateTimeInterface
    {
        return $this->updateTime;
    }
}
