<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/11/17
 * Time: 3:33 PM
 */

namespace Gamer\Controllers;

use Gamer\Models\MatchHistory;
use \Gamer\Models\Token as Token;
use \Gamer\Http\StatusCodes;
use PHPUnit\Runner\Exception;


class MatchHistoryController
{

    public function buildMatch($json){
        $buildMatch = new MatchHistory();

        $role = Token::getRoleFromToken();
        if($role == Token::ROLE_ADMIN) {
            try {
                if (isset($json->AwayTeamId) && isset($json->HomeTeamId) && isset($json->MatchDate) && isset($json->WinningTeamId) &&  count((array)$json) == 4) {
                    if ($json->AwayTeamId != NULL && $json->HomeTeamId != NULL && $json->MatchDate != NULL && $json->WinningTeamId != NULL) {

                        $buildMatch->init($json->AwayTeamId, $json->HomeTeamId, $json->MatchDate, $json->WinningTeamId);
                        http_response_code(StatusCodes::CREATED);
                        echo "Match Created\n";
                        return $json;
                    }
                    else {
                        http_response_code(StatusCodes::BAD_REQUEST);
                        return 'Something was left NULL';
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

    public function updateMatch($json){
        $buildMatch = new MatchHistory();

        $role = Token::getRoleFromToken();
        if($role == Token::ROLE_ADMIN) {
            try {
                if (isset($json->MatchId) && isset($json->AwayTeamId) && isset($json->HomeTeamId) && isset($json->MatchDate) && isset($json->WinningTeamId) &&  count((array)$json) == 5) {
                    if ($json->MatchId != NULL && $json->AwayTeamId != NULL && $json->HomeTeamId != NULL && $json->MatchDate != NULL && $json->WinningTeamId != NULL) {

                        $buildMatch->updateMatch($json->MatchId, $json->AwayTeamId, $json->HomeTeamId, $json->MatchDate, $json->WinningTeamId);
                        http_response_code(StatusCodes::OK);
                        echo "Match Updated\n";
                        return $json;
                    }
                    else {
                        http_response_code(StatusCodes::BAD_REQUEST);
                        return 'Something was left NULL';
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


    public function getAllMatches() {
        try{
            return MatchHistory::getAllMatches();
        }
        catch(Exception $e) {
            http_response_code(StatusCodes::BAD_REQUEST);
            return "Sorry something went wrong";
        }

    }

    public function getMatchByMatchID($args){

        try {
            $MatchHistory = new MatchHistory();
            return $MatchHistory->getMatchByMatchID($args['MatchId']);
        }
        catch(Exception $e) {
            http_response_code(StatusCodes::BAD_REQUEST);
            return "Sorry something went wrong";
        }

    }

    public function deleteMatchByMatchID($args)
    {

        $role = Token::getRoleFromToken();
        if ($role == Token::ROLE_ADMIN) {
            $MatchHistory = new MatchHistory();
            return $MatchHistory->deleteMatchByMatchID($args['MatchId']);
        } else {
            http_response_code(StatusCodes::FORBIDDEN);
        }
    }

}