<?php


namespace Insly\TypeObject;

use Insly\Calculator\CarPolicyCalculator;
use Insly\Calculator\PolicyCalculatorInterface;
use Insly\Factory\CarPolicyRequestFactory;
use Insly\Factory\PolicyFactoryInterface;
use Insly\Request\CarPolicyRequest;
use Insly\Factory\PolicyRequestFactoryInterface;
use Insly\Factory\CarPolicyFactory;
use Insly\Policy\CarPolicy;

class CarPolicyType implements PolicyTypeInterface
{
    const REQUEST_FACTORY = CarPolicyRequestFactory::class;
    const POLICY_FACTORY = CarPolicyFactory::class;
    const CALCULATOR = CarPolicyCalculator::class;
    const REQUEST_CLASS = CarPolicyRequest::class;
    const POLICY_CLASS = CarPolicy::class;

    const FEE_INDICATORS = ['base_premium', 'commission', 'tax'];
    const SPECIAL_FEES = ['base_premium'];
    const CONFIG = [
        'base_premium' => [
            'normal' => '11',
            'higher' => '13'
        ],
        'commission' => '17'
    ];

    public function getRequestFactory(): PolicyRequestFactoryInterface
    {
        $name = self::REQUEST_FACTORY;
        $obj = new $name;
        $obj->setType($this);
        return $obj;
    }

    public function getPolicyFactory(): PolicyFactoryInterface
    {
        $name = self::POLICY_FACTORY;
        $obj = new $name;
        $obj->setCalculator($this->getCalculator());
        $obj->setType($this);
        return $obj;
    }

    public function getCalculator(): PolicyCalculatorInterface
    {
        $name = self::CALCULATOR;
        return new $name;
    }

    public function getRequestClassName(): string
    {
        return self::REQUEST_CLASS;
    }

    public function getPolicyClassName(): string
    {
        return self::POLICY_CLASS;
    }

    public function getFees(): array
    {
        return self::FEE_INDICATORS;
    }

    public function getConfig(): array
    {
        return self::CONFIG;
    }

    public function isSpecialFee(string $fee): bool
    {
        return in_array($fee, self::SPECIAL_FEES);
    }
}