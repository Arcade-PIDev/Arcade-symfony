<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class StringExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('string', [$this, 'convertToString']),
        ];
    }

    public function convertToString($value)
    {
        return (string) $value;
    }
}
