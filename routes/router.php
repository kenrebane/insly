<?php

use Insly\PolicyBuilder;
use Insly\TypeObject\CarPolicyType;

$request = $_SERVER['REQUEST_URI'];

switch ($request) {
    case '/api/policy' :

        $json = json_decode(file_get_contents("php://input"), true);
        $policy = (new PolicyBuilder(CarPolicyType::class))->getPolicy($json);
        echo json_encode($policy);
    break;
    default:
        http_response_code(404);
        echo json_encode(['message' => 'something went wrong']);
    break;
}