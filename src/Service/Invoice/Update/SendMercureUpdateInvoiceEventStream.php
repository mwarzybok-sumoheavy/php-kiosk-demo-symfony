<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Service\Invoice\Update;

use App\Entity\Invoice\Invoice;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;

class SendMercureUpdateInvoiceEventStream implements SendUpdateInvoiceEventStream
{
    private HubInterface $hub;

    public function __construct(HubInterface $hub)
    {
        $this->hub = $hub;
    }

    /**
     * @throws \JsonException
     */
    public function execute(
        Invoice $invoice,
        ?UpdateInvoiceEventType $eventType,
        ?string $eventMessage
    ): void {
        $this->hub->publish(new Update(
            ['update-invoice'],
            json_encode(
                [
                    'status' => $invoice->getStatus(),
                    'uuid' => $invoice->getUuid(),
                    'eventType' => strtolower($eventType->name),
                    'eventMessage' => $eventMessage
                ],
                JSON_THROW_ON_ERROR
            )
        ));
    }
}
