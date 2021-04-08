<?php


namespace Insly\Policy;

use Insly\Collection\InstallmentCollection;

class CarPolicy implements PolicyInterface, \JsonSerializable
{
    private array $totals;
    private string $assetPrice;
    private int $installmentCounts;
    private InstallmentCollection $installments;

    public function setAssetPrice($assetPrice): PolicyInterface
    {
        $this->assetPrice = $assetPrice;
        return $this;
    }

    public function getAssetPrice(): string
    {
        return $this->assetPrice;
    }

    public function setInstallmentCounts($installmentCounts): PolicyInterface
    {
        $this->installmentCounts = $installmentCounts;
        return $this;
    }

    public function getInstallmentCounts(): int
    {
        return (int) $this->installmentCounts;
    }

    public function setInstallments($installments): PolicyInterface
    {
        $this->installments = $installments;
        return $this;
    }

    public function getInstallments(): InstallmentCollection
    {
        return $this->installments;
    }

    public function setTotals(array $totals): PolicyInterface
    {
        $this->totals = $totals;
        return $this;
    }

    public function update(): PolicyInterface
    {
        $this->installments->update($this->totals);
        return $this;
    }

    public function jsonSerialize(): array
    {
        return [
            'asset_price' => $this->assetPrice,
            'totals' => $this->totals,
            'installments' => $this->installments
        ];
    }
}