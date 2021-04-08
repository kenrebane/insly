<?php


namespace Insly\Policy;

use Insly\Collection\InstallmentCollection;

interface PolicyInterface
{
    public function setAssetPrice($assetPrice): PolicyInterface;

    public function setInstallmentCounts($installmentCounts): PolicyInterface;

    public function setInstallments($installments): PolicyInterface;

    public function getInstallments(): InstallmentCollection;

    public function jsonSerialize(): array;
}