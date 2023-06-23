<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Controller\Invoice;

use App\Entity\Invoice\Invoice;
use App\Repository\Invoice\InvoiceRepository;
use App\Service\Invoice\Update\SendUpdateInvoiceEventStream;
use App\Service\Shared\Logger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class GetInvoiceView
{
    private Environment $twig;
    private InvoiceRepository $invoiceRepository;
    private Logger $logger;

    public function __construct(
        Environment $twig,
        InvoiceRepository $invoiceRepository,
        Logger $logger
    ) {
        $this->twig = $twig;
        $this->invoiceRepository = $invoiceRepository;
        $this->logger = $logger;
    }

    #[Route('/invoices/{uuid}', name: 'get_invoice', methods: [Request::METHOD_GET])]
    public function execute(string $uuid): Response
    {
        /** @var Invoice $invoice */
        $invoice = $this->invoiceRepository->findOneByUuid($uuid);
        if (!$invoice) {
            return new Response(null, Response::HTTP_NOT_FOUND);
        }

        $this->logger->info('INVOICE_GET', 'Loaded invoice', ['id' => $invoice->getId()]);

        return new Response(
            $this->twig->render(
                'invoice/view.html.twig',
                [
                    'invoice' => $invoice,
                    'sseTopic' => SendUpdateInvoiceEventStream::TOPIC
                ]
            )
        );
    }
}
