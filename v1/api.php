<?php
/**
 * Created by PhpStorm.
 * User: iamcaptaincode
 * Date: 10/13/2016
 * Time: 8:56 AM
 */

require_once 'config.php';
require_once 'vendor/autoload.php';

use Gamer\Controllers\TokensController;
use Gamer\Http\Methods as Methods;

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r)  use ($baseURI) {
    /** TOKENS CLOSURES */
    $handlePostToken = function ($args) {
        $tokenController = new TokensController();
        //Is the data via a form?
        if (!empty($_POST['username'])) {
            $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
            $password = $_POST['password'] ?? "";
        } else {
            //Attempt to parse json input
            $json = (object) json_decode(file_get_contents('php://input'));
            if (count((array)$json) >= 2) {
                $username = filter_var($json->username, FILTER_SANITIZE_STRING);
                $password = $json->password;
            } else {
                http_response_code(\Gamer\Http\StatusCodes::BAD_REQUEST);
                exit();
            }
        }
        return $tokenController->buildToken($username, $password);

    };


    /** ALL Gamers Functions */

    $handlePostGamer = function ($args) {
        $GamersController = new \Gamer\Controllers\GamersController();
        if (empty($json)) {
            $json = (object) json_decode(file_get_contents('php://input'));
        }
        $gamers = $GamersController->buildGamer($json);
        return $gamers;

    };

    $handlePutGamer = function ($args) {
        $GamersController = new \Gamer\Controllers\GamersController();
        if (empty($json)) {
            $json = (object) json_decode(file_get_contents('php://input'));
        }
        $gamers = $GamersController->updateGamer($json);
        return $gamers;

    };




    /** TOKEN ROUTE */
    $r->addRoute(Methods::POST, $baseURI . '/tokens', $handlePostToken);

    /** GAMERS ROUTE */
    $r->addRoute(Methods::POST, $baseURI . '/gamers', $handlePostGamer);
    $r->addRoute(Methods::PUT, $baseURI . '/gamers', $handlePutGamer);





});

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$pos = strpos($uri, '?');
if ($pos !== false) {
    $uri = substr($uri, 0, $pos);
}
$uri = rtrim($uri, "/");

$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($method, $uri);

switch($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(Gamer\Http\StatusCodes::NOT_FOUND);
        //Handle 404
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(Gamer\Http\StatusCodes::METHOD_NOT_ALLOWED);
        //Handle 403
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler  = $routeInfo[1];
        $vars = $routeInfo[2];

        $response = $handler($vars);
        echo json_encode($response);
        break;
}











