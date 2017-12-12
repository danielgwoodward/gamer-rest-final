<?php
/**
 * Created by PhpStorm.
 * User: Nicholas Hayes
 * Date: 12/11/2017
 * Time: 10:32 AM
 */

namespace Games\Controllers;

use Gamer\Models\Gamer;
use \Gamer\Models\Token as Token;
use \Gamer\Http\StatusCodes;

class GamesController
{
    public function buildGame($json){
        $buildGame = new Game();

        $role = Token::getRoleFromToken();
        if($role == Token::ROLE_FACULTY) {
            try {
                if (isset($json->GameName) && isset($json->GameESRBRating) && isset($json->GameCompany) && isset($json->PlayerCount) && isset($json->CreateYear) &&  count((array)$json) == 5) {
                    if ($json->GameName != NULL) {

                        $buildGame->init($json->GameName, $json->GameESRBRating, $json->GameCompany, $json->PlayerCount, $json->CreateYear);
                        http_response_code(StatusCodes::CREATED);
                        echo "Game Created\n";
                        return $json;
                    }
                    else {
                        http_response_code(StatusCodes::BAD_REQUEST);
                        return 'GameName was NULL';
                    }
                }
                else {
                    http_response_code(StatusCodes::BAD_REQUEST);
                    return 'Some fields were left out of the request, or do not match';
                }
            }

            catch (\Exception $e){
                http_response_code(StatusCodes::BAD_REQUEST);
                return "Something went wrong";
            }

        }
        else{
            http_response_code(StatusCodes::FORBIDDEN);
            return 'You do not have authorization';
        }
    }

    public function updateGame($json){
        $updateGame = new Game();

        $role = Token::getRoleFromToken();
        if($role == Token::ROLE_FACULTY) {
            try {
                if (isset($json->GameId) && isset($json->GameName) && isset($json->GameESRBRating) && isset($json->GameCompany) && isset($json->PlayerCount) && isset($json->CreateYear) &&  count((array)$json) == 6) {
                    if ($json->GameId != NULL && $json->GameName != NULL) {

                        $updateGame->updateGame($json->GameId, $json->GameName, $json->GameESRBRating, $json->GameCompany, $json->PlayerAmount, $json->CreateYear);
                        http_response_code(StatusCodes::CREATED);
                        echo "Game Updated\n";
                        return $json;
                    }
                    else {
                        http_response_code(StatusCodes::BAD_REQUEST);
                        return 'GameId or GameName was NULL';
                    }
                }
                else {
                    http_response_code(StatusCodes::BAD_REQUEST);
                    return 'Some fields were left out of the request, or do not match';
                }
            }

            catch (\Exception $e){
                http_response_code(StatusCodes::BAD_REQUEST);
                return "Something went wrong";
            }

        }
        else{
            http_response_code(StatusCodes::FORBIDDEN);
            return 'You do not have authorization';
        }
    }

    public function getAllGames() {
        $role = Token::getRoleFromToken();
        if($role == Token::ROLE_FACULTY) {
            return Game::getAllGames();
        }
        else {
            http_response_code(StatusCodes::FORBIDDEN);
            return 'You do not have authorization';
        }
    }

    public function getGameByGameID($args){
        $role = Token::getRoleFromToken();
        if($role == Token::ROLE_FACULTY){

            return Game::getGameByGameID($args['GameId']);
        }
        else {
            http_response_code(StatusCodes::FORBIDDEN);
            return 'You do not have authorization';
        }
    }

    public function deleteGameByGameID($args){
        $role = Token::getRoleFromToken();
        if($role == Token::ROLE_FACULTY){

            return Game::deleteGameByGameID($args['GameId']);
        }
        else {
            http_response_code(StatusCodes::FORBIDDEN);
            return 'You do not have authorization';
        }
    }
}