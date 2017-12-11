<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/11/17
 * Time: 4:25 PM
 */

namespace Gamer\Testing;

use Gamer\Controllers\TokensController;
use Gamer\Http\Methods;
use \PHPUnit\Framework\TestCase;
use \Gamer\Http\StatusCodes;
use Gamer\Utilities\Testing;

class testMatchHistory extends TestCase
{
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
        $endpoint = "/match";
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
        $endpoint = "/match";
        try {
            $output = Testing::callAPIOverHTTP($endpoint, Methods::POST, $body, $token, Testing::JSON);
        } catch (\Exception $err) {
            $this->assertEmpty($err->getMessage(), "Error message: ". $err->getMessage());
        }
        $this->assertNotFalse($output);
        $this->assertEquals(StatusCodes::BAD_REQUEST, Testing::getLastHTTPResponseCode());
    }
    public function testAdminPOSTMoreAttributes() //Test Admin POST with more than 4 Fields in the array
    {
        $token = $this->generateToken('genericfac', 'Hello896');
        $json = array(
            "EXTRA" => "NODONTDOTHAT",
            "GamerTag"=> "TheSpicyNoodle",
            "TeamId" => "1",
            "MainGamePlayedId" => "1",
            "Rank" =>"Gold"

        );
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

    public function testAdminPost() //Admin should be able to POST
    {
        $token = $this->generateToken('genericfac', 'Hello896');
        $json = array(
            "AwayTeamId"=>"1",
            "HomeTeamId"=>"2",
            "MatchDate"=>"2017/12/12",
            "WinningTeamId"=>"2"
        );
        $body = json_encode($json);
        $endpoint = "/match";
        try {
            $output = Testing::callAPIOverHTTP($endpoint, Methods::POST, $body, $token, Testing::JSON);
        } catch (\Exception $err) {
            $this->assertEmpty($err->getMessage(), "Error message: ". $err->getMessage());
        }
        $this->assertNotFalse($output);
        $this->assertEquals(StatusCodes::CREATED, Testing::getLastHTTPResponseCode());
    }

    public function testAdminPut() //Admin should be able to POST
    {
        $token = $this->generateToken('genericfac', 'Hello896');
        $json = array(

                 "MatchId"=>"2",
                 "AwayTeamId"=>"1",
                 "HomeTeamId"=>"2",
                 "MatchDate"=>"2017/12/12",
                 "WinningTeamId"=>"2"

        );
        $body = json_encode($json);
        $endpoint = "/match";
        try {
            $output = Testing::callAPIOverHTTP($endpoint, Methods::PUT, $body, $token, Testing::JSON);
        } catch (\Exception $err) {
            $this->assertEmpty($err->getMessage(), "Error message: ". $err->getMessage());
        }
        $this->assertNotFalse($output);
        $this->assertEquals(StatusCodes::CREATED, Testing::getLastHTTPResponseCode());
    }

    public function testGetMatchId() {

        $token = $this->generateToken("genericfac", "Hello896");
        $body_contents = array();
        $body = json_encode($body_contents);
        $endpoint = "/match/2";

        try {
            $output = Testing::callAPIOverHTTP($endpoint, Methods::GET, $body, $token, Testing::JSON);
        } catch (\Exception $err) {
            $this->assertEmpty($err->getMessage(), "Error message: ". $err->getMessage());
        }

        $this->assertNotFalse($output); //False on error, otherwise it's the raw results. You should be able to json_decode to read the response.
        $this->assertEquals(200, Testing::getLastHTTPResponseCode());


    }

    public function testGetAllGamers()
    {
        $token = $this->generateToken("genericfac", "Hello896");
        $body_contents = array();
        $body = json_encode($body_contents);
        $endpoint = "/match";

        try {
            $output = Testing::callAPIOverHTTP($endpoint, Methods::GET, $body, $token, Testing::JSON);
        } catch (\Exception $err) {
            $this->assertEmpty($err->getMessage(), "Error message: ". $err->getMessage());
        }

        $this->assertNotFalse($output); //False on error, otherwise it's the raw results. You should be able to json_decode to read the response.
        $this->assertEquals(200, Testing::getLastHTTPResponseCode());
        //$this->assertJsonStringEqualsJsonString(""); //Compare against expected JSON object. You  could also do other tests.


    }

    public function testDeleteGamerId() {

        $token = $this->generateToken("genericfac", "Hello896");
        $body_contents = array();
        $body = json_encode($body_contents);
        $endpoint = "/match/admin/2";

        try {
            $output = Testing::callAPIOverHTTP($endpoint, Methods::DELETE, $body, $token, Testing::JSON);
        } catch (\Exception $err) {
            $this->assertEmpty($err->getMessage(), "Error message: ". $err->getMessage());
        }

        $this->assertNotFalse($output); //False on error, otherwise it's the raw results. You should be able to json_decode to read the response.
        $this->assertEquals(200, Testing::getLastHTTPResponseCode());


    }



}