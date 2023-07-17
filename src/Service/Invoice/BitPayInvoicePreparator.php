<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Service\Invoice;

use App\Service\Invoice\Create\CreateInvoice;

class BitPayInvoicePreparator
{
    /**
     * This method adapt invoice data from BitPay REST API to be valid (eg. null -> false)
     * @param array $data
     * @return array
     */
    public function execute(array &$data, string $className): array
    {
        $reflection = new \ReflectionClass($className);
        $properties = $reflection->getProperties();
        $booleanFields = [];
        $classes = [];

        foreach ($properties as $property) {
            $type = $property->getType()?->getName();

            if ($type === 'bool') {
                $booleanFields[] = $property->getName();
                continue;
            }

            if (str_starts_with($type, 'App\Entity\Invoice')) {
                $classes[$property->getName()] = $type;
            }
        }

        $this->prepareBooleanValues($data, $booleanFields);
        $this->prepareDefaultValues($data);

        foreach ($classes as $key => $class) {
            if (!array_key_exists($key, $data)) {
                continue;
            }
            $this->execute($data[$key], $class);
        }

        return $data;
    }

    private function prepareBooleanValues(array &$data, $booleanFields): void
    {
        foreach ($booleanFields as $booleanField) {
            if (!array_key_exists($booleanField, $data)) {
                continue;
            }

            $data[$booleanField] = $data[$booleanField] ?? false;
        }
    }

    private function prepareDefaultValues(array &$data): void
    {
        $defaultValues = [
            'currencyCode' => 'USD',
            'targetConfirmations' => 0,
            'transactionSpeed' => CreateInvoice::DEFAULT_TRANSACTION_SPEED
        ];

        foreach ($defaultValues as $key => $defaultValue) {
            if (!array_key_exists($key, $data)) {
                continue;
            }

            $value = $data[$key] ?? null;
            if (!$value) {
                $data[$key] = $defaultValue;
            }
        }
    }
}
