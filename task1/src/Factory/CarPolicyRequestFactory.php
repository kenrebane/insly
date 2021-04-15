<?php

namespace Insly\Factory;

use Insly\TypeObject\CarPolicyType;
use Insly\Request\CarPolicyRequest;

class CarPolicyRequestFactory implements PolicyRequestFactoryInterface
{
    private CarPolicyType $type;
    private CarPolicyRequest $request;

    public function setType(CarPolicyType $type)
    {
        $this->type = $type;
    }

    public function create(array $config): CarPolicyRequest
    {
        $class = $this->type->getRequestClassName();
        $this->request = new $class();
        $this->request->setAssetPrice($config['asset_price']);
        $this->request->setInstallmentCount($config['installment_count']);
        $this->request->setFees($this->combineFees($config));
        return $this->request;
    }

    private function combineFees(array $config): array
    {
        $clone = array_map(function () { return 0; }, array_flip($this->type->getFees()));
        foreach ($this->type->getFees() as $fee) {
            if (isset($config[$fee])) {
                if ($this->type->isSpecialFee($fee)) {
                    $clone[$fee] = $this->handleSpecialFee($fee, $config);
                } else {
                    $clone[$fee] = $config[$fee];
                }
            }
        }
        return $clone;
    }

    private function handleSpecialFee($fee, $config)
    {
        switch($fee) {
            case 'base_premium':
                return $this->getCurrentBasePremRate($config);
        }
        return null;
    }

    private function getCurrentBasePremRate($config)
    {
        if (($config['time']['day'] == 5) && ($config['time']['hour'] > 15) && ($config['time']['hour'] < 20)) {
            return $config['base_premium']['higher'];
        }
        return $config['base_premium']['normal'];
    }
}