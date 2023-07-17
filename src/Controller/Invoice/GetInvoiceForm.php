<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Controller\Invoice;

use App\Configuration\BitPayConfigurationInterface;
use App\Service\Invoice\Update\SendUpdateInvoiceEventStream;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class GetInvoiceForm
{
    private Environment $twig;
    private BitPayConfigurationInterface $bitPayConfiguration;

    public function __construct(
        Environment $twig,
        BitPayConfigurationInterface $bitPayConfiguration,
    ) {
        $this->twig = $twig;
        $this->bitPayConfiguration = $bitPayConfiguration;
    }

    #[Route('/', name: 'get_invoice_form', methods: [Request::METHOD_GET])]
    public function execute(#[MapQueryParameter] ?string $errorMessage): Response
    {
        $design = $this->bitPayConfiguration->getMode();

        return new Response($this->twig->render(
            'invoice/create_' . $design->value . '.html.twig',
            [
                'sseTopic' => SendUpdateInvoiceEventStream::TOPIC,
                'errorMessage' => $errorMessage
            ]
        ));
    }
}
