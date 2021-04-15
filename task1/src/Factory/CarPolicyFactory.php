<?php


namespace Insly\Factory;

use Insly\Request\CarPolicyRequest;
use Insly\Calculator\CarPolicyCalculator;
use Insly\TypeObject\CarPolicyType;
use Insly\Collection\InstallmentCollection;
use Insly\Policy\CarPolicy;
use Insly\Policy\PolicyInterface;

class CarPolicyFactory implements PolicyFactoryInterface
{
    private CarPolicyCalculator $calculator;
    private CarPolicyType $type;
    private CarPolicy $policy;

    public function setType(CarPolicyType $type)
    {
        $this->type = $type;
    }

    public function setCalculator(CarPolicyCalculator $calculator)
    {
        $this->calculator = $calculator;
    }

    public function create(CarPolicyRequest $request): PolicyInterface
    {
        $className = $this->type->getPolicyClassName();
        $this->policy = new $className;
        $this->policy->setAssetPrice($request->price());
        $this->policy->setInstallmentCounts($request->installments());
        $this->policy->setTotals($this->calculator->calculate($request->price(), $request->fees()));
        $installments = $this->calculator->calculate($request->price(), $request->fees(), $request->installments());
        $collection = (new InstallmentCollection($installments, $request->installments()))->totals();
        $this->policy->setInstallments($collection);
        $this->policy->update();
        return $this->policy;
    }
}