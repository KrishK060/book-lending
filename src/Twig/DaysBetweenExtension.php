<?php

namespace App\Twig;

use App\Repository\LoanRepository;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class DaysBetweenExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('days_between', [$this, 'calculateDaysBetween']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function calculateDaysBetween(?\DateTimeInterface $enddate): ?int
    {
        $startdate = new \DateTimeImmutable();
        if (!$startdate || !$enddate) {
            return null;
        }

        $interval = $startdate->diff($enddate);
        return $interval->days;
    }
}
