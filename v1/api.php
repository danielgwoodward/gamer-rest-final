<?php
/**
 * Created by PhpStorm.
 * User: dan
 * Date:12/10/2017
 * Time: 9:50 AM
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

    //POST
    $handlePostGamer = function ($args) {
        $GamersController = new \Gamer\Controllers\GamersController();
        if (empty($json)) {
            $json = (object) json_decode(file_get_contents('php://input'));
        }
        $gamers = $GamersController->buildGamer($json);
        return $gamers;

    };
    //PUT
    $handlePutGamer = function ($args) {
        $GamersController = new \Gamer\Controllers\GamersController();
        if (empty($json)) {
            $json = (object) json_decode(file_get_contents('php://input'));
        }
        $gamers = $GamersController->updateGamer($json);
        return $gamers;

    };

    //GET ALL
    $handleGetAllGamers = function () {
        $gamersController = new \Gamer\Controllers\GamersController();
        $gamers = $gamersController->getAllGamers();
        return $gamers;
    };

    //GET SPECIFIC
    $handleGetGamerId = function ($args) {
        $gamersController = new \Gamer\Controllers\GamersController();
        $gamers = $gamersController->getGamerByGamerID($args);
        return $gamers;

    };

    //DELETE
    $handleDeleteGamerId = function ($args) {
        $gamersController = new \Gamer\Controllers\GamersController();
        $gamers = $gamersController->deleteGamerByGamerID($args);
        return $gamers;
    };

    /** ALL MatchHistory Functions */

    //POST
    $handlePostMatchHistory = function ($args) {
        $MatchController = new \Gamer\Controllers\MatchHistoryController();
        if (empty($json)) {
            $json = (object) json_decode(file_get_contents('php://input'));
        }
        $matches = $MatchController->buildMatch($json);
        return $matches;

    };

    //PUT
    $handlePutMatchHistory = function ($args) {
        $matchesController = new \Gamer\Controllers\MatchHistoryController();
        if (empty($json)) {
            $json = (object) json_decode(file_get_contents('php://input'));
        }
        $matches = $matchesController->updateMatch($json);
        return $matches;

    };

    //GET ALL
    $handleGetAllMatches = function () {
        $matchesController = new \Gamer\Controllers\MatchHistoryController();
        $matches = $matchesController->getAllMatches();
        return $matches;
    };

    //GET SPECIFIC
    $handleGetMatchId = function ($args) {
        $matchesController = new \Gamer\Controllers\MatchHistoryController();
        $matches = $matchesController->getMatchByMatchID($args);
        return $matches;

    };

    //DELETE
    $handleDeleteMatchId = function ($args) {
        $matchesController = new \Gamer\Controllers\MatchHistoryController();
        $matches = $matchesController->deleteMatchByMatchID($args);
        return $matches;
    };


    /** ALL PlayerGamesList Functions */

    //POST
    $handlePostPlayerGList = function ($args) {
        $PlayerGListController = new \Gamer\Controllers\PlayerGamesListController();
        if (empty($json)) {
            $json = (object) json_decode(file_get_contents('php://input'));
        }
        $playerglist = $PlayerGListController->buildPlayerGList($json);
        return $playerglist;

    };

    //PUT
    $handlePutPlayerGList = function ($args) {
        $playerglistController = new \Gamer\Controllers\PlayerGamesListController();
        if (empty($json)) {
            $json = (object) json_decode(file_get_contents('php://input'));
        }
        $playerglist = $playerglistController->updatePlayerGList($json);
        return $playerglist;

    };

    //GET ALL
    $handleGetAllPlayerGList = function () {
        $playerglistController = new \Gamer\Controllers\PlayerGamesListController();
        $playerglist = $playerglistController->getPlayerGList();
        return $playerglist;
    };

    //GET SPECIFIC
    $handleGetPlayerGList = function ($args) {
        $playerglistController = new \Gamer\Controllers\PlayerGamesListController();
        $playerglist = $playerglistController->getGamerByGamerID($args);
        return $playerglist;

    };

    //DELETE
    $handleDeletePlayerGList = function ($args) {
        $playerglistController = new \Gamer\Controllers\PlayerGamesListController();
        $playerglist = $playerglistController->deleteGamerByGamerID($args);
        return $playerglist;
    };
    /** ALL Teams Functions */


    //POST
    $handlePostTeam = function ($args) {
        $TeamController = new \Gamer\Controllers\TeamsController();
        if (empty($json)) {
            $json = (object) json_decode(file_get_contents('php://input'));
        }
        $team = $TeamController->buildTeam($json);
        return $team;

    };

    //PUT
    $handlePutTeam = function ($args) {
        $TeamController = new \Gamer\Controllers\TeamsController();
        if (empty($json)) {
            $json = (object) json_decode(file_get_contents('php://input'));
        }
        $team = $TeamController->updateTeam($json);
        return $team;

    };

    //GET ALL
    $handleGetAllTeams = function () {
        $TeamController = new \Gamer\Controllers\TeamsController();
        $team = $TeamController->getAllTeams();
        return $team;
    };

    //GET SPECIFIC
    $handleGetTeamId = function ($args) {
        $TeamController = new \Gamer\Controllers\TeamsController();
        $team = $TeamController->getTeamByTeamID($args);
        return $team;

    };

    //DELETE
    $handleDeleteTeamId = function ($args) {
        $TeamController = new \Gamer\Controllers\TeamsController();
        $team = $TeamController->deleteTeamByTeamID($args);
        return $team;
    };

    /** ALL Games Functions */

    //POST
    $handlePostGame = function ($args) {
        $GameController = new \Gamer\Controllers\GamesController();
        if (empty($json)) {
            $json = (object) json_decode(file_get_contents('php://input'));
        }
        $Game = $GameController->buildGame($json);
        return $Game;

    };

    //PUT
    $handlePutGame = function ($args) {
        $GameController = new \Gamer\Controllers\GamesController();
        if (empty($json)) {
            $json = (object) json_decode(file_get_contents('php://input'));
        }
        $Game = $GameController->updateGame($json);
        return $Game;

    };

    //GET ALL
    $handleGetAllGames = function () {
        $GameController = new \Gamer\Controllers\GamesController();
        $Game = $GameController->getAllGames();
        return $Game;
    };

    //GET SPECIFIC
    $handleGetGameId = function ($args) {
        $GameController = new \Gamer\Controllers\GamesController();
        $Game = $GameController->getGameByGameID($args);
        return $Game;

    };

    //DELETE
    $handleDeleteGameId = function ($args) {
        $GameController = new \Gamer\Controllers\GamesController();
        $Game = $GameController->deleteGameByGameID($args);
        return $Game;
    };



    /** TOKEN ROUTE */  
    $r->addRoute(Methods::POST, $baseURI . '/tokens', $handlePostToken);

    /** GAMERS ROUTE */
    $r->addRoute(Methods::POST, $baseURI . '/gamers', $handlePostGamer);
    $r->addRoute(Methods::PUT, $baseURI . '/gamers', $handlePutGamer);
    $r->addRoute(Methods::GET, $baseURI . '/gamers', $handleGetAllGamers);
    $r->addRoute(Methods::GET, $baseURI . '/gamers/{GamerId:\d+}', $handleGetGamerId);
    $r->addRoute(Methods::DELETE, $baseURI . '/gamers/admin/{GamerId:\d+}', $handleDeleteGamerId);

    /** MatchHistory */
    $r->addRoute(Methods::POST, $baseURI . '/match', $handlePostMatchHistory);
    $r->addRoute(Methods::PUT, $baseURI . '/match', $handlePutMatchHistory);
    $r->addRoute(Methods::GET, $baseURI . '/match', $handleGetAllMatches);
    $r->addRoute(Methods::GET, $baseURI . '/match/{MatchId:\d+}', $handleGetMatchId);
    $r->addRoute(Methods::DELETE, $baseURI . '/match/admin/{MatchId:\d+}', $handleDeleteMatchId);


    /** PlayerGamesList */
    $r->addRoute(Methods::POST, $baseURI . '/playerglist', $handlePostPlayerGList);
    $r->addRoute(Methods::PUT, $baseURI . '/playerglist', $handlePutPlayerGList);
    $r->addRoute(Methods::GET, $baseURI . '/playerglist', $handleGetAllPlayerGList);
    $r->addRoute(Methods::GET, $baseURI . '/playerglist/{GamerId:\d+}', $handleGetPlayerGList);
    $r->addRoute(Methods::DELETE, $baseURI . '/playerglist/admin/{GamerId:\d+}/{GameId:\d+}', $handleDeletePlayerGList);


    /** GAMES ROUTES */
    $r->addRoute(Methods::POST, $baseURI . '/games', $handlePostGame);
    $r->addRoute(Methods::PUT, $baseURI . '/games', $handlePutGame);
    $r->addRoute(Methods::GET, $baseURI . '/games', $handleGetAllGames);
    $r->addRoute(Methods::GET, $baseURI . '/games/{GameId:\d+}', $handleGetGameId);
    $r->addRoute(Methods::DELETE, $baseURI . '/games/admin/{GameId:\d+}', $handleDeleteGameId);

    /** TEAMS ROUTES */
    $r->addRoute(Methods::POST, $baseURI . '/teams', $handlePostTeam);
    $r->addRoute(Methods::PUT, $baseURI . '/teams', $handlePutTeam);
    $r->addRoute(Methods::GET, $baseURI . '/teams', $handleGetAllTeams);
    $r->addRoute(Methods::GET, $baseURI . '/teams/{TeamId:\d+}', $handleGetTeamId);
    $r->addRoute(Methods::DELETE, $baseURI . '/teams/admin/{TeamId:\d+}', $handleDeleteTeamId);


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