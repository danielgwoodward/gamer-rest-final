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
        return (new Token())->testForUser($username, $password);
    }
}
