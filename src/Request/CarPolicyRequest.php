<?php


namespace Insly\Request;


class CarPolicyRequest implements PolicyRequestInterface
{
    private array $fees;
    private array $totals;
    private string $assetPrice;
    private int $installmentCount;

    public function setFees(array $fees): PolicyRequestInterface
    {
        $this->fees = $fees;
        return $this;
    }

    public function setSingleFee(string $name, $value): PolicyRequestInterface
    {
        $this->fees[$name] = $value;
        return $this;
    }

    public function fees(): array
    {
        return $this->fees;
    }

    public function setTotals(array $totals): PolicyRequestInterface
    {
        $this->totals = $totals;
        return $this;
    }

    public function setAssetPrice($assetPrice): PolicyRequestInterface
    {
        $this->assetPrice = $assetPrice;
        return $this;
    }

    public function price(): string
    {
        return $this->assetPrice;
    }

    public function setInstallmentCount($installmentCount): PolicyRequestInterface
    {
        $this->installmentCount = $installmentCount;
        return $this;
    }

    public function installments(): int
    {
        return (int) $this->installmentCount;
    }
}