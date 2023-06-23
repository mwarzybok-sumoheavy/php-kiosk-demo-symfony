<?php

namespace App\Entity\Invoice;

use App\Repository\Invoice\PaymentCurrencyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentCurrencyRepository::class)]
#[ORM\Table(name: 'invoice_payment_currency')]
class PaymentCurrency
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $currencyCode = null;

    #[ORM\Column(type: 'bigint', length: 255, nullable: true)]
    private ?string $total = null;

    #[ORM\Column(type: 'bigint', length: 255, nullable: true)]
    private ?string $subtotal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $displayTotal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $displaySubtotal = null;

    #[ORM\OneToOne(inversedBy: 'paymentCurrency', cascade: ['persist', 'remove'])]
    private ?PaymentCurrencySupportedTransactionCurrency $supportedTransactionCurrency = null;

    #[ORM\OneToOne(inversedBy: 'paymentCurrency', cascade: ['persist', 'remove'])]
    private ?PaymentCurrencyMinerFee $minerFee = null;

    #[ORM\ManyToOne(inversedBy: 'currencies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Payment $payment = null;

    #[ORM\OneToMany(mappedBy: 'paymentCurrency', targetEntity: PaymentCurrencyExchangeRate::class, orphanRemoval: true)]
    private Collection $exchangeRates;

    #[ORM\OneToMany(mappedBy: 'paymentCurrency', targetEntity: PaymentCurrencyCode::class, orphanRemoval: true)]
    private Collection $currencyCodes;

    public function __construct()
    {
        $this->exchangeRates = new ArrayCollection();
        $this->currencyCodes = new ArrayCollection();
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

    /**
     * Should be string cause the value of int may exceed the limit
     * @return string|null
     */
    public function getTotal(): ?string
    {
        return $this->total;
    }

    public function setTotal(?string $total): void
    {
        $this->total = $total;
    }

    public function getSubtotal(): ?string
    {
        return $this->subtotal;
    }

    public function setSubtotal(?string $subtotal): void
    {
        $this->subtotal = $subtotal;
    }

    public function getDisplayTotal(): ?string
    {
        return $this->displayTotal;
    }

    public function setDisplayTotal(?string $displayTotal): void
    {
        $this->displayTotal = $displayTotal;
    }

    public function getDisplaySubtotal(): ?string
    {
        return $this->displaySubtotal;
    }

    public function setDisplaySubtotal(?string $displaySubtotal): void
    {
        $this->displaySubtotal = $displaySubtotal;
    }

    public function getSupportedTransactionCurrency(): ?PaymentCurrencySupportedTransactionCurrency
    {
        return $this->supportedTransactionCurrency;
    }

    public function setSupportedTransactionCurrency(
        ?PaymentCurrencySupportedTransactionCurrency $supportedTransactionCurrency
    ): void {
        $this->supportedTransactionCurrency = $supportedTransactionCurrency;
    }

    public function getMinerFee(): ?PaymentCurrencyMinerFee
    {
        return $this->minerFee;
    }

    public function setMinerFee(?PaymentCurrencyMinerFee $minerFee): void
    {
        $this->minerFee = $minerFee;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(?Payment $payment): void
    {
        $this->payment = $payment;
    }

    /**
     * @return Collection<int, PaymentCurrencyExchangeRate>
     */
    public function getExchangeRates(): Collection
    {
        return $this->exchangeRates;
    }

    public function addExchangeRate(PaymentCurrencyExchangeRate $exchangeRate): void
    {
        if (!$this->exchangeRates->contains($exchangeRate)) {
            $this->exchangeRates->add($exchangeRate);
            $exchangeRate->setPaymentCurrency($this);
        }
    }

    public function removeExchangeRate(PaymentCurrencyExchangeRate $exchangeRate): void
    {
        if (!$this->exchangeRates->removeElement($exchangeRate)) {
            return;
        }

        if ($exchangeRate->getPaymentCurrency() === $this) {
            $exchangeRate->setPaymentCurrency(null);
        }
    }

    /**
     * @return Collection<int, PaymentCurrencyCode>
     */
    public function getCurrencyCodes(): Collection
    {
        return $this->currencyCodes;
    }

    public function addCurrencyCode(PaymentCurrencyCode $currencyCode): void
    {
        if (!$this->currencyCodes->contains($currencyCode)) {
            $this->currencyCodes->add($currencyCode);
            $currencyCode->setPaymentCurrency($this);
        }
    }

    public function removeCurrencyCode(PaymentCurrencyCode $currencyCode): void
    {
        if (!$this->currencyCodes->removeElement($currencyCode)) {
            return;
        }

        if ($currencyCode->getPaymentCurrency() === $this) {
            $currencyCode->setPaymentCurrency(null);
        }
    }
}
