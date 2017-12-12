<?php
/**
 * Created by PhpStorm.
 * User: Joshua
 * Date: 10/24/2016
 * Time: 12:55 PM
 */

namespace Gamer\Controllers;

use \Gamer\Models\Token as Token;
use \Gamer\Http\StatusCodes;
use Gamer\Utilities\DatabaseConnection;


class TokensController
{
    public function buildToken(string $username, string $password)
    {
        $dbh = DatabaseConnection::getInstance();
        $stmtGetAll = $dbh->prepare("Select * From `gamer_api`.`Users` 
                                     WHERE Username = :username
                                     AND Password = :password");
        $stmtGetAll->bindParam(":username", $username);
        $stmtGetAll->bindParam(":password", $password);
        $stmtGetAll->execute();
        $User = $stmtGetAll->FetchAll(\PDO::FETCH_CLASS, "Gamer\Models\Token");

        //If there wasn't a user in the database then exit with bad request
        if (!is_array($User)) {
            http_response_code(StatusCodes::BAD_REQUEST);
            exit("Not a user");
        }

        //Assign role
        if (strtoupper($User[0]['UserId']) == "USER") {
            $role = Token::ROLE_USER;
        } else if (strtoupper($User[0]['UserId']) == "ADMIN") {
            $role = Token::ROLE_ADMIN;
        }

        //If the user didn't have one of these roles then they can't have a token
        if ($role == '') {
            http_response_code(StatusCodes::FORBIDDEN);
            exit("Not authorized");
        }

        return (new Token())->buildToken($role, $username);
    }
}
