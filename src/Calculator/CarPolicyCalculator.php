<?php


namespace Insly\Calculator;


class CarPolicyCalculator implements PolicyCalculatorInterface
{
    private $total;

    public function calculate($assetPrice, $fees, $count = null): array
    {
        $this->total = 0;
        $result = [];
        foreach ($fees as $type => $percentage) {
            if ($type == 'base_premium') {
                $result[$type] = $this->handle($assetPrice, $count, $percentage);
            } else {
                $result[$type] = $this->handle($result['base_premium'], null, $percentage);
            }
        }
        $result['total'] = $this->cut($this->total);
        return $result;
    }

    private function handle($price, $count, $percentage): ?string
    {
        return $this->cut($this->totalup($this->fraction($this->base($price, $count), $percentage)));
    }

    private function cut($price): ?string
    {
        return bcdiv($price, 1, 2);
    }

    private function fraction($price, $percentage)
    {
        return $price * ($percentage / 100);
    }

    private function base($price, ?int $count)
    {
        return is_null($count) ? $price : ($price / $count);
    }

    private function totalup($amount)
    {
        isset($this->total) ? $this->total += $amount : $this->total = $amount;
        return $amount;
    }
}