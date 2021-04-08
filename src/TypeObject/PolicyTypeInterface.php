<?php

namespace Insly\TypeObject;

interface PolicyTypeInterface
{
    public function getRequestFactory();

    public function getPolicyFactory();

    public function getCalculator();

    public function getConfig();
}