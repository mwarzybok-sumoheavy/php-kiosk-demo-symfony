<?php

namespace App\Entity\Invoice;

use App\Repository\Invoice\PaymentCurrencySupportedTransactionCurrencyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentCurrencySupportedTransactionCurrencyRepository::class)]
#[ORM\Table(name: 'invoice_payment_currency_supported_transaction')]
class PaymentCurrencySupportedTransactionCurrency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $enabled = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reason = null;

    #[ORM\OneToOne(mappedBy: 'supportedTransactionCurrency', cascade: ['persist', 'remove'])]
    private ?PaymentCurrency $paymentCurrency = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(?bool $enabled): void
    {
        $this->enabled = $enabled;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): void
    {
        $this->reason = $reason;
    }

    public function getPaymentCurrency(): ?PaymentCurrency
    {
        return $this->paymentCurrency;
    }

    public function setPaymentCurrency(?PaymentCurrency $paymentCurrency): void
    {
        if ($paymentCurrency === null && $this->paymentCurrency !== null) {
            $this->paymentCurrency->setSupportedTransactionCurrency(null);
        }

        if ($paymentCurrency !== null && $paymentCurrency->getSupportedTransactionCurrency() !== $this) {
            $paymentCurrency->setSupportedTransactionCurrency($this);
        }

        $this->paymentCurrency = $paymentCurrency;
    }
}
