<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Tests;

use App\Entity\Invoice\Buyer;
use App\Entity\Invoice\Invoice;
use App\Entity\Invoice\Payment;
use App\Entity\Invoice\PaymentCurrency;

class ExampleInvoice
{
    public const UUID = '04373e9d-d265-4a07-aea4-c8a67c253968';
    public const TOKEN = 'someToken';
    public const BITPAY_ID = 'someBitpayId';
    public const BITPAY_ORDER_ID = 'someBitpayOrderId';
    public const ITEM_DESCRIPTION = 'someDecription';
    public const DEFAULT_PRICE = 12.35;

    public static function create(): Invoice
    {
        $invoice = new Invoice();
        $invoice->setCreatedDate(new \DateTimeImmutable('2023-01-22'));
        $invoice->setUuid(self::UUID);
        $invoice->setPrice(self::DEFAULT_PRICE);
        $invoice->setToken(self::TOKEN);
        $invoice->setBitpayId(self::BITPAY_ID);
        $invoice->setBitpayOrderId(self::BITPAY_ORDER_ID);
        $invoice->setBitpayUrl('someBitpayUrl');
        $invoice->setStatus('new');
        $invoice->setCurrencyCode('USD');
        $invoice->setItemDescription(self::ITEM_DESCRIPTION);

        $invoiceBuyer = new Buyer();
        $invoiceBuyer->setName('SomeName');
        $invoiceBuyer->setAddress1('SomeAddress');

        $invoicePayment = new Payment();
        $invoicePayment->setAmountPaid(1);

        $invoicePaymentCurrency = new PaymentCurrency();
        $invoicePaymentCurrency->setCurrencyCode('BTC');
        $invoicePaymentCurrency->setTotal('25');
        $invoicePaymentCurrency->setSubtotal('25');
        $invoicePaymentCurrency->setDisplayTotal('0.25');
        $invoicePaymentCurrency->setDisplaySubtotal('0.25');

        $invoice->setPayment($invoicePayment);
        $invoice->setBuyer($invoiceBuyer);
        $invoicePayment->addCurrency($invoicePaymentCurrency);

        return $invoice;
    }
}
