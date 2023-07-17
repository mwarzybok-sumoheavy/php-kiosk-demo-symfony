<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Service\Invoice\Create;

use App\Configuration\BitPayConfigurationInterface;
use App\Configuration\Mode;
use App\Entity\Invoice\Invoice;
use App\Factory\BitPayClientFactory;
use App\Factory\UuidFactory;
use App\Repository\Invoice\InvoiceRepositoryInterface;
use App\Service\Invoice\BitPayInvoiceToEntityConverter;
use App\Service\Shared\Logger;
use App\Service\Shared\UrlProvider;
use BitPaySDK\Exceptions\BitPayException;
use BitPaySDK\Model\Facade;
use BitPaySDK\Model\Invoice\Buyer;
use BitPaySDK\Model\Invoice\Invoice as BitPayInvoice;

class CreateInvoice
{
    public const DEFAULT_TRANSACTION_SPEED = 'medium';

    private CreateInvoiceValidator $validator;
    private BitPayConfigurationInterface $bitPayConfiguration;
    private BitPayClientFactory $bitPayClientFactory;
    private InvoiceRepositoryInterface $invoiceRepository;
    private UuidFactory $uuidFactory;
    private UrlProvider $urlProvider;
    private Logger $logger;
    private BitPayInvoiceToEntityConverter $bitPayInvoiceToEntityConverter;

    public function __construct(
        BitPayConfigurationInterface $bitPayConfiguration,
        BitPayClientFactory $bitPayClientFactory,
        BitPayInvoiceToEntityConverter $bitPayInvoiceToEntityConverter,
        InvoiceRepositoryInterface $invoiceRepository,
        CreateInvoiceValidator $createInvoiceValidator,
        UuidFactory $uuidFactory,
        UrlProvider $urlProvider,
        Logger $logger
    ) {
        $this->bitPayConfiguration = $bitPayConfiguration;
        $this->bitPayClientFactory = $bitPayClientFactory;
        $this->bitPayInvoiceToEntityConverter = $bitPayInvoiceToEntityConverter;
        $this->invoiceRepository = $invoiceRepository;
        $this->validator = $createInvoiceValidator;
        $this->uuidFactory = $uuidFactory;
        $this->urlProvider = $urlProvider;
        $this->logger = $logger;
    }

    public function execute(array $data): Invoice
    {
        try {
            $validatedParams = $this->validator->execute($data);
            $uuid = $this->uuidFactory->create();
            $requestData = $this->createBitPayInvoice($validatedParams, $uuid);
            $bitPayInvoice = $this->sendBitPayInvoice($requestData);

            $invoice = $this->bitPayInvoiceToEntityConverter->execute($bitPayInvoice, $uuid);
            $this->invoiceRepository->save($invoice, true);

            $this->logger->info('INVOICE_CREATE_SUCCESS', 'Successfully created invoice', [
                'id' => $invoice->getId()
            ]);
        } catch (BitPayException | \JsonException $e) {
            $this->logger->error('INVOICE_CREATE_FAIL', 'Failed to create invoice', [
                'errorMessage' => $e->getMessage(),
                'stackTrace' => $e->getTraceAsString()
            ]);
            throw new \RuntimeException($e->getMessage());
        }

        return $invoice;
    }

    private function createBitPayInvoice(array $validatedParams, string $uuid): BitPayInvoice
    {
        $price = $validatedParams['price'];
        $posDataJson = json_encode($validatedParams, JSON_THROW_ON_ERROR);
        $invoice = new BitPayInvoice((float)$price, $this->bitPayConfiguration->getCurrencyIsoCode());
        $notificationEmail = $this->bitPayConfiguration->getNotificationEmail();
        $notificationUrl = $this->getNotificationUrl($uuid);
        $invoiceMode = $this->bitPayConfiguration->getMode();

        $invoice->setOrderId((string)uniqid('', true));
        $invoice->setTransactionSpeed(self::DEFAULT_TRANSACTION_SPEED);
        $invoice->setItemDesc($invoiceMode->value);
        $invoice->setPosData($posDataJson);
        $invoice->setNotificationURL($notificationUrl);
        $invoice->setExtendedNotifications(true);

        if ($invoiceMode === Mode::DONATION) {
            $invoice->setBuyer($this->getBuyer($validatedParams));
        }

        if ($notificationEmail) {
            $invoice->setNotificationEmail($notificationEmail);
        }

        return $invoice;
    }

    private function getNotificationUrl(string $uuid): string
    {
        return sprintf("%s/invoices/%s", $this->urlProvider->applicationUrl(), $uuid);
    }

    private function getBuyer(array $validatedParams): Buyer
    {
        $buyer = new Buyer();
        $buyer->setName($validatedParams['buyerName'] ?? null);
        $buyer->setAddress1($validatedParams['buyerAddress1'] ?? null);
        $buyer->setLocality($validatedParams['buyerLocality'] ?? null);
        $buyer->setRegion($validatedParams['buyerRegion'] ?? null);
        $buyer->setPostalCode($validatedParams['buyerPostalCode'] ?? null);
        $buyer->setCountry('US');
        $buyer->setEmail($validatedParams['buyerEmail'] ?? null);
        $buyer->setPhone($validatedParams['buyerPhone'] ?? null);

        if (isset($validatedParams['buyerAddress2'])) {
            $buyer->setAddress2($validatedParams['buyerAddress2'] ?? null);
        }

        return $buyer;
    }

    private function sendBitPayInvoice(BitPayInvoice $bitPayInvoice): BitPayInvoice
    {
        $client = $this->bitPayClientFactory->create();

        $facade = $this->bitPayConfiguration->getFacade();
        $signRequest = $facade !== Facade::POS;

        return $client->createInvoice($bitPayInvoice, $facade, $signRequest);
    }
}
