<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/10/17
 * Time: 5:12 PM
 */

namespace Gamer\Testing;



use Gamer\Controllers\TokensController;
use Gamer\Http\Methods;
use \PHPUnit\Framework\TestCase;
use \Gamer\Http\StatusCodes;
use Gamer\Utilities\Testing;



class testGamers extends TestCase {

    private function generateToken($username, $password)
    {
        $tokenController = new TokensController();
        return $tokenController->buildToken($username, $password);
    }

    public function testAdminNULLPUT() //Test Faculty with NULL PUT Body
    {
        $token = $this->generateToken('genericfac', 'Hello896');
        $json = NULL;
        $body = json_encode($json);
        $endpoint = "/gamers";
        try {
            $output = Testing::callAPIOverHTTP($endpoint, Methods::PUT, $body, $token, Testing::JSON);
        } catch (\Exception $err) {
            $this->assertEmpty($err->getMessage(), "Error message: ". $err->getMessage());
        }
        $this->assertNotFalse($output);
        $this->assertEquals(StatusCodes::BAD_REQUEST, Testing::getLastHTTPResponseCode());
    }

    public function testAdminNULLPOST() //Test Faculty with NULL POST Body
    {
        $token = $this->generateToken('genericfac', 'Hello896');
        $json = NULL;
        $body = json_encode($json);
        $endpoint = "/gamers";
        try {
            $output = Testing::callAPIOverHTTP($endpoint, Methods::POST, $body, $token, Testing::JSON);
        } catch (\Exception $err) {
            $this->assertEmpty($err->getMessage(), "Error message: ". $err->getMessage());
        }
        $this->assertNotFalse($output);
        $this->assertEquals(StatusCodes::BAD_REQUEST, Testing::getLastHTTPResponseCode());
    }


}