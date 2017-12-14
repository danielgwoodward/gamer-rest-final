<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/11/17
 * Time: 6:31 PM
 */

namespace Gamer\Controllers;

use Gamer\Models\PlayerGamesList;
use \Gamer\Models\Token as Token;
use \Gamer\Http\StatusCodes;
use PHPUnit\Runner\Exception;


class PlayerGamesListController
{

    public function buildPlayerGList($json){
        $buildPlayerGamesList = new PlayerGamesList();


       $role = Token::getRoleFromToken();
        if($role == Token::ROLE_ADMIN) {
            try {
                if (isset($json->GameId) && isset($json->GamerId) && count((array)$json) == 2) {
                    if ($json->GameId != NULL && $json->GamerId != NULL) {

                        $buildPlayerGamesList->init($json->GamerId, $json->GameId);
                        http_response_code(StatusCodes::CREATED);
                        echo "Added to the Database\n";
                        return $json;
                    }
                    else {
                        http_response_code(StatusCodes::BAD_REQUEST);
                        return 'Something was NULL, need to include both GamerId and GameId';
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

        }
    }

    public function updatePlayerGList($json){
        $updatePlayerGamesList = new PlayerGamesList();


        $role = Token::getRoleFromToken();
        if($role == Token::ROLE_ADMIN) {
            try {
                if (isset($json->GameId) && isset($json->GamerId) && count((array)$json) == 2) {
                    if ($json->GameId != NULL && $json->GamerId != NULL) {

                        $updatePlayerGamesList->updatePlayerGList($json->GamerId, $json->GameId);

                        http_response_code(StatusCodes::OK);
                        echo "Added to the Database\n";
                        return $json;
                    }
                    else {
                        http_response_code(StatusCodes::BAD_REQUEST);
                        return 'Something was NULL, need to include both GamerId and GameId';
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

        }
    }


    public function getPlayerGList() {
        try{
            return PlayerGamesList::getPlayerGList();
        }
        catch(Exception $e) {
            http_response_code(StatusCodes::BAD_REQUEST);
            return "Sorry something went wrong";
        }

    }

    public function getGamerByGamerID($args){

        try {
            $PlayerGList = new PlayerGamesList();
            return $PlayerGList->getGamerPlayerGList($args['GamerId']);
        }
        catch(Exception $e) {
            http_response_code(StatusCodes::BAD_REQUEST);
            return "Sorry something went wrong";
        }

    }

    public function deleteGamerByGamerID($args){


        $role = Token::getRoleFromToken();
        if($role == Token::ROLE_ADMIN) {
            $PlayerGList = new PlayerGamesList();
            return $PlayerGList->deletePlayerGList($args['GamerId'], $args['GameId']);
        }
        else {
            http_response_code(StatusCodes::FORBIDDEN);
        }

    }

}