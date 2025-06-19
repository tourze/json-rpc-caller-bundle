<?php

namespace Tourze\JsonRPCCallerBundle\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Tourze\DoctrineIndexedBundle\Attribute\IndexColumn;
use Tourze\DoctrineSnowflakeBundle\Service\SnowflakeIdGenerator;
use Tourze\DoctrineTimestampBundle\Traits\TimestampableAware;
use Tourze\DoctrineTrackBundle\Attribute\TrackColumn;
use Tourze\DoctrineUserBundle\Traits\BlameableAware;
use Tourze\JsonRPCCallerBundle\Repository\ApiCallerRepository;

/**
 * 主要用来识别接口调用方，目前只有签名业务用到
 *
 * @see https://happypeter.github.io/binfo/aes
 */
#[IsGranted('ROLE_ADMIN')]
#[ORM\Entity(repositoryClass: ApiCallerRepository::class)]
#[ORM\Table(name: 'api_caller', options: ['comment' => 'API调用者'])]
class ApiCaller implements \Stringable
{
    use TimestampableAware;
    use BlameableAware;
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(SnowflakeIdGenerator::class)]
    #[ORM\Column(type: Types::STRING, nullable: false, options: ['comment' => 'ID'])]
    private ?string $id = null;

    #[ORM\Column(type: Types::STRING, length: 60, unique: true, options: ['comment' => '名称'])]
    private string $title;

    #[ORM\Column(type: Types::STRING, length: 64, unique: true, nullable: false, options: ['comment' => 'AppID'])]
    private string $appId;

    #[ORM\Column(type: Types::STRING, length: 120, options: ['comment' => 'AppSecret'])]
    private ?string $appSecret = null;

    #[ORM\Column(type: Types::JSON, nullable: true, options: ['comment' => '允许调用IP'])]
    private ?array $allowIps = [];

    #[ORM\Column(type: Types::INTEGER, nullable: true, options: ['comment' => '签名超时时间', 'default' => 180])]
    private ?int $signTimeoutSecond = 180;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['comment' => 'AES Key'])]
    private ?string $aesKey = null;

    #[ORM\Column(type: Types::TEXT, nullable: true, options: ['comment' => '备注', 'default' => ''])]
    private ?string $remark = null;

    #[IndexColumn]
    #[TrackColumn]
    #[ORM\Column(type: Types::BOOLEAN, nullable: true, options: ['comment' => '有效', 'default' => 0])]
    private ?bool $valid = false;

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

    public function __toString(): string
    {
        return $this->title;
    }
}
