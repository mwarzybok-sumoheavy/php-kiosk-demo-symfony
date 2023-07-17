<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Controller\Invoice;

use App\Exception\InvalidConfiguration;
use App\Exception\ValidationFailed;
use App\Service\Invoice\Create\CreateInvoice as CreateInvoiceService;
use BitPaySDK\Exceptions\BitPayException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\RouterInterface;

class CreateInvoice
{
    private CreateInvoiceService $createInvoiceService;
    private RouterInterface $router;

    public function __construct(CreateInvoiceService $createInvoice, RouterInterface $router)
    {
        $this->createInvoiceService = $createInvoice;
        $this->router = $router;
    }

    #[Route('/invoices', name: 'create_invoice', methods: [Request::METHOD_POST])]
    public function execute(Request $request): Response
    {
        try {
            $invoice = $this->createInvoiceService->execute($request->request->all());
        } catch (BitPayException | ValidationFailed | InvalidConfiguration $e) {
            $route = $this->router->generate('get_invoice_form', ['errorMessage' => $e->getMessage()]);
            return new RedirectResponse($route);
        }

        return new RedirectResponse($invoice->getBitpayUrl());
    }
}
