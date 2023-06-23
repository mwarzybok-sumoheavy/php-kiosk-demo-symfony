<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Service\Invoice;

use App\Entity\Invoice\Invoice;
use App\Repository\Invoice\InvoiceRepositoryInterface;
use BitPaySDK\Model\Invoice\Invoice as BitPayInvoice;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class BitPayInvoiceToEntityConverter
{
    private SerializerInterface $serializer;
    private BitPayInvoicePreparator $bitPayInvoicePreparator;
    private InvoiceRepositoryInterface $invoiceRepository;

    public function __construct(
        SerializerInterface $serializer,
        BitPayInvoicePreparator $bitPayInvoicePreparator,
        InvoiceRepositoryInterface $invoiceRepository
    ) {
        $this->serializer = $serializer;
        $this->bitPayInvoicePreparator = $bitPayInvoicePreparator;
        $this->invoiceRepository = $invoiceRepository;
    }

    public function execute(BitPayInvoice $bitPayInvoice, string $uuid): Invoice
    {
        $context = [];
        $invoice = $this->invoiceRepository->findOneByUuid($uuid);
        if ($invoice) {
            $context = [
                AbstractNormalizer::OBJECT_TO_POPULATE => $invoice
            ];
        }

        $result = [
            'buyer' => $this->getBuyer($bitPayInvoice),
            'payment' => $this->getPayment($bitPayInvoice),
            'refund' => $this->getRefund($bitPayInvoice),
            'posDataJson' => $bitPayInvoice->getPosData(),
            'price' => $bitPayInvoice->getPrice(),
            'currencyCode' => $bitPayInvoice->getCurrency(),
            'bitpayId' => $bitPayInvoice->getId(),
            'status' => $bitPayInvoice->getStatus(),
            'createdDate' => $bitPayInvoice->getInvoiceTime(),
            'expirationTime' => $bitPayInvoice->getExpirationTime(),
            'bitpayOrderId' => $bitPayInvoice->getOrderId(),
            'facadeType' => 'pos/invoice',
            'bitpayGuid' => $bitPayInvoice->getGuid(),
            'exceptionStatus' => $bitPayInvoice->getExceptionStatus(),
            'bitpayUrl' => $bitPayInvoice->getUrl(),
            'redirectUrl' => $bitPayInvoice->getRedirectURL(),
            'closeUrl' => $bitPayInvoice->getCloseURL(),
            'acceptanceWindow' => $bitPayInvoice->getAcceptanceWindow(),
            'token' => $bitPayInvoice->getToken(),
            'merchantName' => $bitPayInvoice->getMerchantName(),
            'itemDescription' => $bitPayInvoice->getItemDesc(),
            'billId' => $bitPayInvoice->getBillId(),
            'targetConfirmations' => $bitPayInvoice->getTargetConfirmations(),
            'lowFeeDetected' => $bitPayInvoice->getLowFeeDetected(),
            'autoRedirect' => $bitPayInvoice->getAutoRedirect(),
            'shopperUser' => $bitPayInvoice->getShopper() ? $bitPayInvoice->getShopper()->getUser() : null,
            'jsonPayProRequired' => $bitPayInvoice->getJsonPayProRequired(),
            'bitpayIdRequired' => $bitPayInvoice->getBitpayIdRequired(),
            'isCancelled' => $bitPayInvoice->getIsCancelled(),
            'transactionSpeed' => $bitPayInvoice->getTransactionSpeed(),
            'url' => $bitPayInvoice->getUrl(),
            'uuid' => $uuid
        ];
        $result = $this->bitPayInvoicePreparator->execute($result, Invoice::class);

        return $this->serializer->denormalize($result, Invoice::class, null, $context);
    }

    private function getBuyer(BitPayInvoice $bitPayInvoice): ?array
    {
        $bitPayBuyer = $bitPayInvoice->getBuyer();
        if (!$bitPayBuyer) {
            return null;
        }

        return [
            'name' => $bitPayBuyer->getName(),
            'address1' => $bitPayBuyer->getAddress1(),
            'address2' => $bitPayBuyer->getAddress2(),
            'city' => $bitPayBuyer->getLocality(),
            'region' => $bitPayBuyer->getRegion(),
            'postalCode' => $bitPayBuyer->getPostalCode(),
            'country' => $bitPayBuyer->getCountry(),
            'email' => $bitPayBuyer->getEmail(),
            'phone' => $bitPayBuyer->getPhone(),
            'notify' => $bitPayBuyer->getNotify(),
            'providedEmail' => $bitPayInvoice->getBuyerProvidedEmail(),
            'providedInfo' => $this->getBuyerProvidedInfo($bitPayInvoice),
        ];
    }

    private function getBuyerProvidedInfo(BitPayInvoice $bitPayInvoice): ?array
    {
        $bitpayBuyerProvidedInfo = $bitPayInvoice->getBuyerProvidedInfo();
        if (!$bitpayBuyerProvidedInfo) {
            return null;
        }

        return [
            'name' => $bitpayBuyerProvidedInfo->getName(),
            'phoneNumber' => $bitpayBuyerProvidedInfo->getPhoneNumber(),
            'selectedWallet' => $bitpayBuyerProvidedInfo->getSelectedWallet(),
            'emailAddress' => $bitpayBuyerProvidedInfo->getEmailAddress(),
            'selectedTransactionCurrency' => $bitpayBuyerProvidedInfo->getSelectedTransactionCurrency(),
            'sms' => $bitpayBuyerProvidedInfo->getSms(),
            'smsVerified' => $bitpayBuyerProvidedInfo->getSmsVerified(),
        ];
    }

    /**
     * @param BitPayInvoice $bitPayInvoice
     * @param \BitPaySDK\Model\Invoice\UniversalCodes|null $universalCodes
     * @return array
     */
    private function getPayment(BitPayInvoice $bitPayInvoice,): array
    {
        $universalCodes = $bitPayInvoice->getUniversalCodes();

        return [
            'currencies' => $this->getCurrencies($bitPayInvoice),
            'amountPaid' => $bitPayInvoice->getAmountPaid(),
            'displayAmountPaid' => $bitPayInvoice->getDisplayAmountPaid(),
            'underpaidAmount' => $bitPayInvoice->getUnderpaidAmount(),
            'overpaidAmount' => $bitPayInvoice->getOverpaidAmount(),
            'nonPayProPaymentReceived' => $bitPayInvoice->getNonPayProPaymentReceived() ?? false,
            'universalCodesPaymentString' => $universalCodes ? $universalCodes->getPaymentString() : null,
            'universalCodesVerificationLink' => $universalCodes ? $universalCodes->getVerificationLink() : null,
            'transactionCurrency' => $bitPayInvoice->getTransactionCurrency(),
        ];
    }

    private function getRefund(BitPayInvoice $bitPayInvoice)
    {
        $bitPayRefundInfo = $bitPayInvoice->getRefundInfo();

        return [
            'info' => $bitPayRefundInfo ? [
                'currencyCode' => $bitPayRefundInfo->getCurrency(),
                'supportRequest' => $bitPayRefundInfo->getSupportRequest(),
            ] : null,
            'addressesJson' => $bitPayInvoice->getRefundAddresses()
                ? json_encode($bitPayInvoice->getRefundAddresses(), JSON_THROW_ON_ERROR) : null,
            'addressRequestPending' => $bitPayInvoice->getRefundAddressRequestPending() ?? false,
            'amounts' => $this->getBitpayRefundInfoAmounts($bitPayRefundInfo)
        ];
    }

    private function getBitpayRefundInfoAmounts(?\BitPaySDK\Model\Invoice\RefundInfo $bitPayRefundInfo): ?array
    {
        if (!$bitPayRefundInfo || !$bitPayRefundInfo->getAmounts()) {
            return null;
        }

        $result = [];
        foreach ($bitPayRefundInfo->getAmounts() as $currencyCode => $amount) {
            $result[] = [
                'currencyCode' => $currencyCode,
                'amount' => $amount,
            ];
        }

        return $result;
    }

    private function getCurrencies(BitPayInvoice $bitPayInvoice): array
    {
        $paymentTotals = $bitPayInvoice->getPaymentTotals();
        $paymentSubtotals = $bitPayInvoice->getPaymentSubtotals();
        if (!$paymentTotals) {
            return [];
        }

        $invoicePaymentCurrencies = [];
        foreach ($paymentTotals as $currency => $value) {
            $invoicePaymentCurrencies[$currency] = [
                'currency_code' => $currency,
                'total' => (string)$value
            ];
            $paymentSubtotal = $paymentSubtotals[$currency] ?? null;
            if ($paymentSubtotal !== null) {
                $invoicePaymentCurrencies[$currency]['subtotal'] = (string)$paymentSubtotal;
            }
        }

        $result = [];
        foreach ($invoicePaymentCurrencies as $invoicePaymentCurrency) {
            $result[] = $invoicePaymentCurrency;
        }

        return $result;
    }
}
