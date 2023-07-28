<?php

namespace App\Twig;

use Twig\Extension\RuntimeExtensionInterface;

class TruncateRuntime implements RuntimeExtensionInterface
{
    public function handle(string $value): string
    {
        return substr($value, 0, 150);
    }
}