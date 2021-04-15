<?php


namespace Insly\Calculator;

interface PolicyCalculatorInterface
{
    public function calculate($assetPrice, $fees, $count = null): array;
}