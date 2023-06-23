<?php

namespace App\Entity\Invoice;

use App\Repository\Invoice\BuyerRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BuyerRepository::class)]
#[ORM\Table(name: 'invoice_buyer')]
class Buyer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $address2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $city = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $region = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $postalCode = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $notify = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $providedEmail = null;

    #[ORM\OneToOne(mappedBy: 'buyer', cascade: ['persist'])]
    private ?Invoice $invoice = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?BuyerProvidedInfo $providedInfo = null;

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

    public function getAddress1(): ?string
    {
        return $this->address1;
    }

    public function setAddress1(?string $address1): void
    {
        $this->address1 = $address1;
    }

    public function getAddress2(): ?string
    {
        return $this->address2;
    }

    public function setAddress2(?string $address2): void
    {
        $this->address2 = $address2;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    public function setRegion(?string $region): void
    {
        $this->region = $region;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): void
    {
        $this->postalCode = $postalCode;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): void
    {
        $this->country = $country;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): void
    {
        $this->phone = $phone;
    }

    public function getNotify(): ?string
    {
        return $this->notify;
    }

    public function setNotify(?string $notify): void
    {
        $this->notify = $notify;
    }

    public function getProvidedInfo(): ?BuyerProvidedInfo
    {
        return $this->providedInfo;
    }

    public function setProvidedInfo(?BuyerProvidedInfo $providedInfo): void
    {
        $this->providedInfo = $providedInfo;
    }

    /**
     * @return string|null
     */
    public function getProvidedEmail(): ?string
    {
        return $this->providedEmail;
    }

    /**
     * @param string|null $providedEmail
     */
    public function setProvidedEmail(?string $providedEmail): void
    {
        $this->providedEmail = $providedEmail;
    }

    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(?Invoice $invoice): void
    {
        if ($invoice === null && $this->invoice !== null) {
            $this->invoice->setBuyer(null);
        }

        if ($invoice !== null && $invoice->getBuyer() !== $this) {
            $invoice->setBuyer($this);
        }

        $this->invoice = $invoice;
    }
}
