<?php

namespace Insly;

use Insly\TypeObject\PolicyTypeInterface;
use Insly\Factory\PolicyRequestFactoryInterface;
use Insly\Factory\PolicyFactoryInterface;
use Insly\Policy\PolicyInterface;

class PolicyBuilder
{
    private array $config;
    private PolicyTypeInterface $type;
    private PolicyFactoryInterface $policyFactory;
    private PolicyRequestFactoryInterface $requestfactory;

    public function __construct(string $type)
    {
        $obj  = new $type();
        if ($obj instanceof PolicyTypeInterface) {
            $this->type = $obj;
        } else {
            throw new \InvalidArgumentException();
        }
        $this->setRequestFactory($this->type->getRequestFactory());
        $this->setPolicyFactory($this->type->getPolicyFactory());
        $this->setConfig($this->type->getConfig());
    }

    public function setRequestFactory(PolicyRequestFactoryInterface $factory): PolicyBuilder
    {
        $this->requestfactory = $factory;
        return $this;
    }

    public function setPolicyFactory(PolicyFactoryInterface $factory): PolicyBuilder
    {
        $this->policyFactory = $factory;
        return $this;
    }

    private function setConfig(array $config): PolicyBuilder
    {
        $this->config = $config;
        return $this;
    }

    public function getPolicy(array $request): PolicyInterface
    {
        return $this->policyFactory->create($this->requestfactory->create(array_merge($request, $this->config)));
    }
}