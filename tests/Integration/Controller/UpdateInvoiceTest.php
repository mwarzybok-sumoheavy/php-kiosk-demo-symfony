<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Tests\Integration\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UpdateInvoiceTest extends WebTestCase
{
    /**
     * @test
     * @throws \JsonException
     */
    public function it_should_throws_404_for_update_invoice_with_non_existing_uuid(): void
    {
        $json = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'updateInvoice.json');
        $client = static::createClient();

        $client->request(
            'POST',
            '/invoices/non-existing-uuid',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            $json
        );
        self::assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);
    }
}
