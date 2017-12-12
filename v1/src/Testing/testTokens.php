<?php
/**
 * Created by PhpStorm.
 * User: Nicholas Hayes
 * Date: 12/11/2017
 * Time: 8:18 PM
 */

namespace Games\Testing;

use Gamer\Controllers\TokensController;
use Gamer\Http\Methods;
use \PHPUnit\Framework\TestCase;
use \Gamer\Http\StatusCodes;
use Gamer\Utilities\Testing;
use Gamer\Models\Token;

class testTokens extends TestCase
{
    public function testPostAsUser()
    {
        $token = $this->generateToken('User', 'User');
        $this->assertNotNull($token);
        $this->assertEquals(Token::ROLE_USER, Token::getRoleFromToken($token));
    }
    public function testPostAsAdmin()
    {
        $token = $this->generateToken('Admin', 'Admin');
        $this->assertNotNull($token);
        $this->assertEquals(Token::ROLE_ADMIN, Token::getRoleFromToken($token));
    }
    private function generateToken($username, $password)
    {
        $tokenController = new TokensController();
        return $tokenController->buildToken($username, $password);
    }
    public function testCurl()
    {
        $token = "";
        $body_contents = array("username"=>"Admin", "password"=>"Admin");
        $body = json_encode($body_contents);
        $endpoint = "/tokens";
        try {
            $output = Testing::callAPIOverHTTP($endpoint, Methods::POST, $body, $token, Testing::JSON);
        } catch (\Exception $err) {
            $this->assertEmpty($err->getMessage(), "Error message: ". $err->getMessage());
        }
        $this->assertNotFalse($output); //False on error, otherwise it's the raw results. You should be able to json_decode to read the response.
        $this->assertEquals(200, Testing::getLastHTTPResponseCode());
        //$this->assertJsonStringEqualsJsonString(""); //Compare against expected JSON object. You  could also do other tests.
    }
}