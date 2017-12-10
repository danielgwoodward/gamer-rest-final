<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/10/17
 * Time: 1:47 PM
 */

namespace Gamer\Controllers;

use Gamer\Models\Gamer;
use \Gamer\Models\Token as Token;
use \Gamer\Http\StatusCodes;


class GamersController
{

    public function buildGamer($json){
        $buildGamer = new Gamer();

        $role = Token::getRoleFromToken();
        if($role == Token::ROLE_FACULTY) {
            try {
                if (isset($json->GamerTag) && isset($json->TeamId) && isset($json->MainGamePlayedId) && isset($json->Rank) &&  count((array)$json) == 4) {
                    if ($json->GamerTag != NULL) {

                            $buildGamer->init($json->GamerTag, $json->TeamId, $json->MainGamePlayedId, $json->Rank);
                            http_response_code(StatusCodes::CREATED);
                            echo "Gamer Created\n";
                            return $json;
                    }
                    else {
                        http_response_code(StatusCodes::BAD_REQUEST);
                        return 'GamerTag was NULL';
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
            http_response_code(StatusCodes::UNAUTHORIZED);
            return 'You do not have authorization';
        }
    }

    public function updateGamer($json){
        $updateGamer = new Gamer();

        $role = Token::getRoleFromToken();
        if($role == Token::ROLE_FACULTY) {
            try {
                if (isset($json->GamerId) && isset($json->GamerTag) && isset($json->TeamId) && isset($json->MainGamePlayedId) && isset($json->Rank) &&  count((array)$json) == 5) {
                    if ($json->GamerId != NULL && $json->GamerTag != NULL) {

                        $updateGamer->updateAward($json->GamerId, $json->GamerTag, $json->TeamId, $json->MainGamePlayedId, $json->Rank);
                        http_response_code(StatusCodes::CREATED);
                        echo "Gamer Updated\n";
                        return $json;
                    }
                    else {
                        http_response_code(StatusCodes::BAD_REQUEST);
                        return 'GamerTag or GamerId was NULL';
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
            http_response_code(StatusCodes::UNAUTHORIZED);
            return 'You do not have authorization';
        }
    }

}