<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Service\Shared;

use Psr\Log\LoggerInterface;

class BitPayLogger implements \App\Service\Shared\Logger
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @throws \JsonException
     */
    public function info(
        string $code,
        string $message,
        array $context
    ): void {
        $this->logger->info($this->jsonFromInput('INFO', $code, $message, $context));
    }

    /**
     * @throws \JsonException
     */
    public function error(string $code, string $message, array $context): void
    {
        $this->logger->info($this->jsonFromInput('ERROR', $code, $message, $context));
    }

    /**
     * @throws \JsonException
     */
    private function jsonFromInput(
        string $level,
        string $code,
        string $message,
        array $context
    ): string {
        return json_encode([
            'level' => $level,
            'timestamp' => time(),
            'code' => $code,
            'message' => $message,
            'context' => $context
        ], JSON_THROW_ON_ERROR);
    }
}
