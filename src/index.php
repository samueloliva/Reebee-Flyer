<?php
require "config.php";

use Service\User as UserService;
use Service\Flyer as FlyerService;
use Service\Page as PageService;

use Controller\User as UserController;
use Controller\Flyer as FlyerController;
use Controller\Page as PageController;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$requestUri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$requestUri = explode("/", $requestUri);

$requestMethod = $_SERVER["REQUEST_METHOD"];

$uriParam = "";
if (isset($requestUri[2])) {
    $uriParam = $requestUri[2];
}

$api = $requestUri[1];
$flyer = false;

if ($api == "user") {
    $service = new UserService($database);
    $controller = new UserController($service, $requestMethod);
    $response = $controller->request();
    header($response['status']['code']);
}
else if ($api == "flyer") {
    $service = new FlyerService($database);
    $flyerController = new FlyerController($service, $requestMethod, $uriParam);
    $response = $flyerController->request();
    header($response['status']["code"]);
}
else if ($api == "page") {
    if ($uriParam == 'flyer') {
        $uriParam = $requestUri[3];
        $flyer = true;
    }
    
    $service = new PageService($database);
    $controller = new PageController($service, $requestMethod, $flyer, $uriParam);
    $response = $controller->request();
    header($response['status']["code"]);
}
else {
    $response['status'] = ["code" => 404, "message" => "Not Found"];
    $response['body'] = null;
    header($response['status']['code']);
    die(json_encode($response['status']));
}

// echo json_encode($response["status"]) . "\n";
echo $response['body'];


