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
use PHPUnit\Runner\Exception;


class GamersController
{

    public function buildGamer($json){
        $buildGamer = new Gamer();

        $role = Token::getRoleFromToken();
        if($role == Token::ROLE_ADMIN) {
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
            http_response_code(StatusCodes::FORBIDDEN);

        }
    }

    public function updateGamer($json){
        $updateGamer = new Gamer();

        $role = Token::getRoleFromToken();
        if($role == Token::ROLE_ADMIN) {
            try {
                if (isset($json->GamerId) && isset($json->GamerTag) && isset($json->TeamId) && isset($json->MainGamePlayedId) && isset($json->Rank) &&  count((array)$json) == 5) {
                    if ($json->GamerId != NULL && $json->GamerTag != NULL) {

                        $updateGamer->updateGamer($json->GamerId, $json->GamerTag, $json->TeamId, $json->MainGamePlayedId, $json->Rank);
                        http_response_code(StatusCodes::OK);
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
            http_response_code(StatusCodes::FORBIDDEN);
        }
    }

    public function getAllGamers() {
      try{
            return Gamer::getAllGamers();
      }
      catch(Exception $e) {
          http_response_code(StatusCodes::BAD_REQUEST);
          return "Sorry something went wrong";
      }

    }

    public function getGamerByGamerID($args){

          try {
              $Gamer = new Gamer();
              return $Gamer->getGamerByGamerID($args['GamerId']);
          }
          catch(Exception $e) {
                  http_response_code(StatusCodes::BAD_REQUEST);
                  return "Sorry something went wrong";
              }

    }

    public function deleteGamerByGamerID($args){

        $role = Token::getRoleFromToken();
        if($role == Token::ROLE_ADMIN) {
            $Gamer = new Gamer();
                  return $Gamer->deleteGamerByGamerID($args['GamerId']);
               }
               else {
            http_response_code(StatusCodes::FORBIDDEN);
        }

    }
}