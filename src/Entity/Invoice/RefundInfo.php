<?php

namespace App\Entity\Invoice;

use App\Repository\Invoice\RefundInfoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RefundInfoRepository::class)]
#[ORM\Table(name: 'invoice_refund_info')]
class RefundInfo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $currencyCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $supportRequest = null;

    #[ORM\OneToMany(mappedBy: 'refundInfo', targetEntity: RefundInfoAmount::class, orphanRemoval: true)]
    private Collection $amounts;

    #[ORM\OneToOne(mappedBy: 'info', cascade: ['persist', 'remove'])]
    private ?Refund $refund = null;

    public function __construct()
    {
        $this->amounts = new ArrayCollection();
    }

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

    public function getSupportRequest(): ?string
    {
        return $this->supportRequest;
    }

    public function setSupportRequest(?string $supportRequest): void
    {
        $this->supportRequest = $supportRequest;
    }

    /**
     * @return Collection<int, RefundInfoAmount>
     */
    public function getAmounts(): Collection
    {
        return $this->amounts;
    }

    public function addAmount(RefundInfoAmount $amount): void
    {
        if (!$this->amounts->contains($amount)) {
            $this->amounts->add($amount);
            $amount->setRefundInfo($this);
        }
    }

    public function removeAmount(RefundInfoAmount $amount): void
    {
        if (!$this->amounts->removeElement($amount)) {
            return;
        }

        if ($amount->getRefundInfo() === $this) {
            $amount->setRefundInfo(null);
        }
    }

    public function getRefund(): ?Refund
    {
        return $this->refund;
    }

    public function setRefund(?Refund $refund): void
    {
        if ($refund === null && $this->refund !== null) {
            $this->refund->setInfo(null);
        }

        if ($refund !== null && $refund->getInfo() !== $this) {
            $refund->setInfo($this);
        }

        $this->refund = $refund;
    }
}
