<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('short_number', [$this, 'shortNumber']),
        ];
    }

    public function shortNumber($number)
    {
        if ($number >= 1000) {
            return round($number / 1000, 1) . 'K';
        }

        return $number;
    }
}