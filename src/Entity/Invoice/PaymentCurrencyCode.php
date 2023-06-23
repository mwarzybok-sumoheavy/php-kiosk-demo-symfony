<?php

namespace App\Entity\Invoice;

use App\Repository\Invoice\PaymentCurrencyCodeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentCurrencyCodeRepository::class)]
#[ORM\Table(name: 'invoice_payment_currency_code')]
class PaymentCurrencyCode
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $codeUrl = null;

    #[ORM\ManyToOne(inversedBy: 'currencyCodes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?PaymentCurrency $paymentCurrency = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    public function getCodeUrl(): ?string
    {
        return $this->codeUrl;
    }

    public function setCodeUrl(?string $codeUrl): void
    {
        $this->codeUrl = $codeUrl;
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
