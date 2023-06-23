<?php

namespace App\Entity\Invoice;

use App\Repository\Invoice\TransactionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransactionRepository::class)]
#[ORM\Table(name: 'invoice_transaction')]
class Transaction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $amount = null;

    #[ORM\Column(nullable: true)]
    private ?int $confirmations = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $receivedTime = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $txid = null;

    #[ORM\OneToOne(mappedBy: 'transaction', cascade: ['persist', 'remove'])]
    private ?TransactionExRate $transactionExRate = null;

    #[ORM\ManyToOne(inversedBy: 'transactions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Invoice $invoice = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?int
    {
        return $this->amount;
    }

    public function setAmount(?int $amount): void
    {
        $this->amount = $amount;
    }

    public function getConfirmations(): ?int
    {
        return $this->confirmations;
    }

    public function setConfirmations(?int $confirmations): void
    {
        $this->confirmations = $confirmations;
    }

    public function getReceivedTime(): ?\DateTimeImmutable
    {
        return $this->receivedTime;
    }

    public function setReceivedTime(?\DateTimeImmutable $receivedTime): void
    {
        $this->receivedTime = $receivedTime;
    }

    public function getTxid(): ?string
    {
        return $this->txid;
    }

    public function setTxid(?string $txid): void
    {
        $this->txid = $txid;
    }

    public function getTransactionExRate(): ?TransactionExRate
    {
        return $this->transactionExRate;
    }

    public function setTransactionExRate(?TransactionExRate $transactionExRate): void
    {
        // unset the owning side of the relation if necessary
        if ($transactionExRate === null && $this->transactionExRate !== null) {
            $this->transactionExRate->setTransaction(null);
        }

        // set the owning side of the relation if necessary
        if ($transactionExRate !== null && $transactionExRate->getTransaction() !== $this) {
            $transactionExRate->setTransaction($this);
        }

        $this->transactionExRate = $transactionExRate;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): void
    {
        $this->invoice = $invoice;
    }
}
