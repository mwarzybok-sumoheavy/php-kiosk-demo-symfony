<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Factory;

use App\Configuration\BitPayConfigurationFactoryInterface;
use App\Exception\InvalidConfiguration;
use BitPaySDK\Client;
use BitPaySDK\PosClient;

class BitPayClientFactory
{
    private BitPayConfigurationFactoryInterface $bitPayConfigurationFactory;

    public function __construct(BitPayConfigurationFactoryInterface $bitPayConfigurationFactory)
    {
        $this->bitPayConfigurationFactory = $bitPayConfigurationFactory;
    }

    /**
     * @throws \BitpaySDK\Exceptions\BitPayException
     */
    public function create(): Client
    {
        $bitPayConfiguration = $this->bitPayConfigurationFactory->create();

        try {
            $bitPayConfiguration->getToken();
        } catch (\TypeError $e) {
            throw new InvalidConfiguration('Missing token');
        }

        try {
            $bitPayConfiguration->getEnvironment();
        } catch (\TypeError $e) {
            throw new InvalidConfiguration('Missing environment');
        }

        return new PosClient($bitPayConfiguration->getToken(), $bitPayConfiguration->getEnvironment());
    }
}
