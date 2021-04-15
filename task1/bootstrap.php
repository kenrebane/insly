<?php
require_once __DIR__ . '/src/PolicyBuilder.php';
require_once __DIR__ . '/src/TypeObject/PolicyTypeInterface.php';
require_once __DIR__ . '/src/TypeObject/CarPolicyType.php';
require_once __DIR__ . '/src/Request/PolicyRequestInterface.php';
require_once __DIR__ . '/src/Request/CarPolicyRequest.php';
require_once __DIR__ . '/src/Policy/PolicyInterface.php';
require_once __DIR__ . '/src/Policy/CarPolicy.php';
require_once __DIR__ . '/src/Factory/PolicyRequestFactoryInterface.php';
require_once __DIR__ . '/src/Factory/PolicyFactoryInterface.php';
require_once __DIR__ . '/src/Factory/CarPolicyRequestFactory.php';
require_once __DIR__ . '/src/Factory/CarPolicyFactory.php';
require_once __DIR__ . '/src/Collection/InstallmentCollection.php';
require_once __DIR__ . '/src/Collection/Installment.php';
require_once __DIR__ . '/src/Calculator/PolicyCalculatorInterface.php';
require_once __DIR__ . '/src/Calculator/CarPolicyCalculator.php';


if (strpos($_SERVER['REQUEST_URI'], 'api')) {
    header('Content-Type: application/json');
    require_once __DIR__ . '/routes/router.php';
    exit();
}
