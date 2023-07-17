<?php

namespace App\Entity\Invoice;

use App\Repository\Invoice\BuyerProvidedInfoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BuyerProvidedInfoRepository::class)]
#[ORM\Table(name: 'invoice_buyer_provided_info')]
class BuyerProvidedInfo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $selectedWallet = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $emailAddress = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $selectedTransactionCurrency = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sms = null;

    #[ORM\Column]
    private ?bool $smsVerified = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    public function getSelectedWallet(): ?string
    {
        return $this->selectedWallet;
    }

    public function setSelectedWallet(?string $selectedWallet): void
    {
        $this->selectedWallet = $selectedWallet;
    }

    public function getEmailAddress(): ?string
    {
        return $this->emailAddress;
    }

    public function setEmailAddress(?string $emailAddress): void
    {
        $this->emailAddress = $emailAddress;
    }

    public function getSelectedTransactionCurrency(): ?string
    {
        return $this->selectedTransactionCurrency;
    }

    public function setSelectedTransactionCurrency(?string $selectedTransactionCurrency): void
    {
        $this->selectedTransactionCurrency = $selectedTransactionCurrency;
    }

    public function getSms(): ?string
    {
        return $this->sms;
    }

    public function setSms(?string $sms): void
    {
        $this->sms = $sms;
    }

    public function isSmsVerified(): ?bool
    {
        return $this->smsVerified;
    }

    public function setSmsVerified(bool $smsVerified): void
    {
        $this->smsVerified = $smsVerified;
    }
}
