<?php

namespace App\Entity\Invoice;

use App\Repository\Invoice\RefundRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RefundRepository::class)]
#[ORM\Table(name: 'invoice_refund')]
class Refund
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $addressesJson = null;

    #[ORM\Column(type: Types::BOOLEAN)]
    private bool $addressRequestPending = false;

    #[ORM\OneToOne(mappedBy: 'refund', cascade: ['persist', 'remove'])]
    private ?Invoice $invoice = null;

    #[ORM\OneToOne(inversedBy: 'refund', cascade: ['persist', 'remove'])]
    private ?RefundInfo $info = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddressesJson(): ?string
    {
        return $this->addressesJson;
    }

    public function setAddressesJson(?string $addressesJson): void
    {
        $this->addressesJson = $addressesJson;
    }

    public function getAddressRequestPending(): bool
    {
        return $this->addressRequestPending;
    }

    public function setAddressRequestPending(bool $addressRequestPending): void
    {
        $this->addressRequestPending = $addressRequestPending;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): void
    {
        if ($invoice === null && $this->invoice !== null) {
            $this->invoice->setRefund(null);
        }

        if ($invoice !== null && $invoice->getRefund() !== $this) {
            $invoice->setRefund($this);
        }

        $this->invoice = $invoice;
    }

    public function getInfo(): ?RefundInfo
    {
        return $this->info;
    }

    public function setInfo(?RefundInfo $info): void
    {
        $this->info = $info;
    }
}
