<?php

namespace App\Entity\Invoice;

use App\Repository\Invoice\PaymentCurrencyExchangeRateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentCurrencyExchangeRateRepository::class)]
#[ORM\Table(name: 'invoice_payment_currency_exchange_rate')]
class PaymentCurrencyExchangeRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $currencyCode = null;

    #[ORM\Column(nullable: true)]
    private ?float $rate = null;

    #[ORM\ManyToOne(inversedBy: 'exchangeRates')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PaymentCurrency $paymentCurrency = null;

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

    public function getRate(): ?float
    {
        return $this->rate;
    }

    public function setRate(?float $rate): void
    {
        $this->rate = $rate;
    }

    public function getPaymentCurrency(): ?PaymentCurrency
    {
        return $this->paymentCurrency;
    }

    public function setPaymentCurrency(?PaymentCurrency $paymentCurrency): void
    {
        $this->paymentCurrency = $paymentCurrency;
    }
}
