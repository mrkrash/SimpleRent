<?php

namespace App\Cart\Application\Service;

class RateService
{
    public function calc(int $days, int $atOne, int $atThree, int $atSeven): float
    {
        $tot = 0;
        while ($days > 0) {
            if ($days >= 7) {
                $tot += $atSeven;
                $days -= 7;
                continue;
            }
            if ($days >= 3) {
                $tot += $atThree;
                $days -= 3;
                continue;
            }
            if ($days >= 1) {
                $tot += $atOne;
                $days -= 1;
            }
        }
        return $tot/100;
    }
}