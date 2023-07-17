<?php

/**
 * Copyright (c) 2019 BitPay
 **/

declare(strict_types=1);

namespace App\Service\Shared;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UrlProvider
{
    private ?string $applicationUrl;
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator, ?string $applicationUrl)
    {
        $this->urlGenerator = $urlGenerator;
        $this->applicationUrl = $applicationUrl;
    }

    public function applicationUrl(): string
    {
        if ($this->applicationUrl) {
            return $this->applicationUrl;
        }

        $requestContext = $this->urlGenerator->getContext();

        return $requestContext->getScheme() . '://' . $requestContext->getHost();
    }
}
