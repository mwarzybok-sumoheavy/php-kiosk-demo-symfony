<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Repository\Invoice;

use App\Entity\Invoice\Invoice;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ObjectRepository;

interface InvoiceRepositoryInterface extends ObjectRepository
{
    public function findOneByUuid(string $uuid): ?Invoice;

    public function getQuery(): Query;

    public function save(Invoice $entity, bool $flush = false): void;
}
