<?php

namespace App\Entity\Invoice;

use App\Repository\Invoice\RefundInfoAmountRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RefundInfoAmountRepository::class)]
#[ORM\Table(name: 'invoice_refund_info_amount')]
class RefundInfoAmount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $currencyCode = null;

    #[ORM\Column(nullable: true)]
    private ?float $amount = null;

    #[ORM\ManyToOne(inversedBy: 'amounts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?RefundInfo $refundInfo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCurrencyCode(): ?string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(?string $currencyCode): void
    {
        $this->currencyCode = $currencyCode;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(?float $amount): void
    {
        $this->amount = $amount;
    }

    public function getRefundInfo(): ?RefundInfo
    {
        return $this->refundInfo;
    }

    public function setRefundInfo(?RefundInfo $refundInfo): void
    {
        $this->refundInfo = $refundInfo;
    }
}
