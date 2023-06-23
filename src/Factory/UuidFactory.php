<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Factory;

interface UuidFactory
{
    public function create(): string;
}
