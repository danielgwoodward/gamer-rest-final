<?php
/**
 * Created by PhpStorm.
 * User: Nicholas Hayes
 * Date: 12/11/2017
 * Time: 9:14 AM
 */

namespace Gamer\Controllers;

use Gamer\Models\Team;
use \Gamer\Models\Token as Token;
use \Gamer\Http\StatusCodes;

class TeamsController
{
    public function buildTeam($json){
        $buildTeam = new Team();

        $role = Token::getRoleFromToken();
        if($role == Token::ROLE_ADMIN) {
            try {
                if (isset($json->TeamName) && isset($json->TeamOwner) && isset($json->TeamMainGameId) && isset($json->TeamSecondaryGameId) && isset($json->TeamCountry) &&  count((array)$json) == 5) {
                    if ($json->TeamName != NULL) {

                        $buildTeam->init($json->TeamName, $json->TeamOwner, $json->TeamMainGameId, $json->TeamSecondaryGameId, $json->TeamCountry);
                        http_response_code(StatusCodes::CREATED);
                        return $json;
                    }
                    else {
                        http_response_code(StatusCodes::BAD_REQUEST);
                        return 'TeamName was NULL';
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

    public function updateTeam($json){
        $updateTeam = new Team();

        $role = Token::getRoleFromToken();
        if($role == Token::ROLE_ADMIN) {
            try {
                if (isset($json->TeamId) && isset($json->TeamName) && isset($json->TeamOwner) && isset($json->TeamMainGameId) && isset($json->TeamSecondaryGameId) && isset($json->TeamCountry) &&  count((array)$json) == 6) {
                    if ($json->TeamId != NULL && $json->TeamName != NULL) {

                        $updateTeam->updateTeam($json->TeamId, $json->TeamName, $json->TeamOwner, $json->TeamMainGameId, $json->TeamSecondaryGameId, $json->TeamCountry);
                        http_response_code(StatusCodes::OK);
                        return $json;
                    }
                    else {
                        http_response_code(StatusCodes::BAD_REQUEST);
                        return 'TeamId or TeamName was NULL';
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

    public function getAllTeams() {
        return Team::getAllTeams();
    }

    public function getTeamByTeamID($args){
        return Team::getTeamByTeamID($args['TeamId']);
    }

    public function deleteTeamByTeamID($args){
        $role = Token::getRoleFromToken();
        if($role == Token::ROLE_ADMIN){

            return Team::deleteTeamByTeamID($args['TeamId']);
        }
        else {
            http_response_code(StatusCodes::FORBIDDEN);
            return 'You do not have authorization';
        }
    }
}