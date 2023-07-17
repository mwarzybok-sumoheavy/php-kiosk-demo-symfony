<?php

namespace App\Entity\Invoice;

use App\Repository\Invoice\TransactionExRateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionExRateRepository::class)]
#[ORM\Table(name: 'invoice_transaction_ex_rate')]
class TransactionExRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'transactionExRate', cascade: ['persist', 'remove'])]
    private ?Transaction $transaction = null;

    #[ORM\Column(length: 10)]
    private ?string $currency = null;

    #[ORM\Column]
    private ?float $amount = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTransaction(): ?Transaction
    {
        return $this->transaction;
    }

    public function setTransaction(?Transaction $transaction): void
    {
        $this->transaction = $transaction;
    }

    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }
}
