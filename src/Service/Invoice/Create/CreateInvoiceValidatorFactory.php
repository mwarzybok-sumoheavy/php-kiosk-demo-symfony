<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Service\Invoice\Create;

use App\Configuration\BitPayConfigurationInterface;
use App\Configuration\Mode;

class CreateInvoiceValidatorFactory
{
    private BitPayConfigurationInterface $bitPayConfiguration;
    private PosParamsValidator $posParamsValidator;
    private DonationParamsValidator $donationParamsValidator;

    public function __construct(
        BitPayConfigurationInterface $bitPayConfiguration,
        PosParamsValidator $posParamsValidator,
        DonationParamsValidator $donationParamsValidator
    ) {
        $this->bitPayConfiguration = $bitPayConfiguration;
        $this->posParamsValidator = $posParamsValidator;
        $this->donationParamsValidator = $donationParamsValidator;
    }

    public function create(): CreateInvoiceValidator
    {
        if ($this->bitPayConfiguration->getMode() === Mode::DONATION) {
            return $this->donationParamsValidator;
        }

        if ($this->bitPayConfiguration->getMode() === Mode::STANDARD) {
            return $this->posParamsValidator;
        }

        throw new \RuntimeException("Wrong MODE in configuration yaml file (application*.yaml");
    }
}
