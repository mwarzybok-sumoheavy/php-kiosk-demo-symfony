<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Controller\Invoice;

use App\Repository\Invoice\InvoiceRepository;
use App\Service\Invoice\Update\SendUpdateInvoiceEventStream;
use App\Service\Shared\Logger;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class GetInvoices
{
    private const ITEMS_PER_PAGE = 10;

    private InvoiceRepository $invoiceRepository;
    private Logger $logger;
    private Environment $twig;
    private PaginatorInterface $paginator;

    public function __construct(
        Environment $twig,
        InvoiceRepository $invoiceRepository,
        PaginatorInterface $paginator,
        Logger $logger
    ) {
        $this->twig = $twig;
        $this->invoiceRepository = $invoiceRepository;
        $this->paginator = $paginator;
        $this->logger = $logger;
    }

    #[Route('/invoices', name: 'get_invoices')]
    public function execute(#[MapQueryParameter] int $page = 1): Response
    {
        $invoices = $this->invoiceRepository->getQuery();

        $this->logger->info('INVOICE_GRID_GET', 'Loaded invoice grid', ['page' => $page]);

        return new Response(
            $this->twig->render(
                'invoice/invoices.html.twig',
                [
                    'pagination' => $this->paginator->paginate($invoices, $page, self::ITEMS_PER_PAGE),
                    'sseTopic' => SendUpdateInvoiceEventStream::TOPIC
                ]
            )
        );
    }
}
