<?php

namespace Insly\Request;

interface PolicyRequestInterface
{
    public function setFees(array $fees);

    public function price(): string;

    public function setAssetPrice($assetPrice): PolicyRequestInterface;

    public function installments(): int;
}