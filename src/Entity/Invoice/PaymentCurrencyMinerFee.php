<?php

namespace App\Entity\Invoice;

use App\Repository\Invoice\PaymentCurrencyMinerFeeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentCurrencyMinerFeeRepository::class)]
#[ORM\Table(name: 'invoice_payment_currency_miner_fee')]
class PaymentCurrencyMinerFee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $satoshisPerByte = null;

    #[ORM\Column(nullable: true)]
    private ?float $totalFee = null;

    #[ORM\Column(nullable: true)]
    private ?float $fiatAmount = null;

    #[ORM\OneToOne(mappedBy: 'minerFee', cascade: ['persist', 'remove'])]
    private ?PaymentCurrency $paymentCurrency = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSatoshisPerByte(): ?int
    {
        return $this->satoshisPerByte;
    }

    public function setSatoshisPerByte(?int $satoshisPerByte): void
    {
        $this->satoshisPerByte = $satoshisPerByte;
    }

    public function getTotalFee(): ?float
    {
        return $this->totalFee;
    }

    public function setTotalFee(?float $totalFee): void
    {
        $this->totalFee = $totalFee;
    }

    public function getFiatAmount(): ?float
    {
        return $this->fiatAmount;
    }

    public function setFiatAmount(?float $fiatAmount): void
    {
        $this->fiatAmount = $fiatAmount;
    }

    public function getPaymentCurrency(): ?PaymentCurrency
    {
        return $this->paymentCurrency;
    }

    public function setPaymentCurrency(?PaymentCurrency $paymentCurrency): void
    {
        if ($paymentCurrency === null && $this->paymentCurrency !== null) {
            $this->paymentCurrency->setMinerFee(null);
        }

        if ($paymentCurrency !== null && $paymentCurrency->getMinerFee() !== $this) {
            $paymentCurrency->setMinerFee($this);
        }

        $this->paymentCurrency = $paymentCurrency;
    }
}
