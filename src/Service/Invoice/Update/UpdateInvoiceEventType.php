<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Service\Invoice\Update;

enum UpdateInvoiceEventType
{
    case SUCCESS;
    case ERROR;
}
