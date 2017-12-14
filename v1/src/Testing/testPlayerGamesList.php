<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/11/17
 * Time: 7:29 PM
 */

namespace Gamer\Testing;



use Gamer\Controllers\TokensController;
use Gamer\Http\Methods;
use \PHPUnit\Framework\TestCase;
use \Gamer\Http\StatusCodes;
use Gamer\Utilities\Testing;

class testPlayerGamesList extends TestCase
{
    private function generateToken($username, $password)
    {
        $tokenController = new TokensController();
        return $tokenController->buildToken($username, $password);
    }

    public function testAdminNULLPUT() //Test Faculty with NULL PUT Body
    {
        $token = $this->generateToken('Admin', 'Admin');
        $token = "\"" . $token . "\"";
        $json = NULL;
        $body = json_encode($json);
        $endpoint = "/playerglist";
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
        $token = $this->generateToken('Admin', 'Admin');
        $token = "\"" . $token . "\"";
        $json = NULL;
        $body = json_encode($json);
        $endpoint = "/playerglist";
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
        $token = $this->generateToken('Admin', 'Admin');
        $token = "\"" . $token . "\"";
        $json = array(
            "EXTRA" => "NODONTDOTHAT",
            "GamerTag"=> "TheSpicyNoodle",
            "TeamId" => "1",
            "MainGamePlayedId" => "1",
            "Rank" =>"Gold"

        );
        $body = json_encode($json);
        $endpoint = "/playerglist";
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
        $token = $this->generateToken('Admin', 'Admin');
        $token = "\"" . $token . "\"";
        $json = array(
            "GamerId"=> "1",
            "GameId" => "1"
        );
        $body = json_encode($json);
        $endpoint = "/playerglist";
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
        $token = $this->generateToken('Admin', 'Admin');
        $token = "\"" . $token . "\"";
        $json = array(
            "GamerId"=> "1",
            "GameId" => "1"
        );
        $body = json_encode($json);
        $endpoint = "/playerglist";
        try {
            $output = Testing::callAPIOverHTTP($endpoint, Methods::PUT, $body, $token, Testing::JSON);
        } catch (\Exception $err) {
            $this->assertEmpty($err->getMessage(), "Error message: ". $err->getMessage());
        }
        $this->assertNotFalse($output);
        $this->assertEquals(StatusCodes::OK, Testing::getLastHTTPResponseCode());
    }

    public function testGetPlayerGame() {

        $token = $this->generateToken('Admin', 'Admin');
        $token = "\"" . $token . "\"";
        $body_contents = array();
        $body = json_encode($body_contents);
        $endpoint = "/playerglist/1";

        try {
            $output = Testing::callAPIOverHTTP($endpoint, Methods::GET, $body, $token, Testing::JSON);
        } catch (\Exception $err) {
            $this->assertEmpty($err->getMessage(), "Error message: ". $err->getMessage());
        }

        $this->assertNotFalse($output); //False on error, otherwise it's the raw results. You should be able to json_decode to read the response.
        $this->assertEquals(200, Testing::getLastHTTPResponseCode());


    }

    public function testGetAllPlayerGameList()
    {
        $token = $this->generateToken('Admin', 'Admin');
        $token = "\"" . $token . "\"";
        $body_contents = array();
        $body = json_encode($body_contents);
        $endpoint = "/playerglist";

        try {
            $output = Testing::callAPIOverHTTP($endpoint, Methods::GET, $body, $token, Testing::JSON);
        } catch (\Exception $err) {
            $this->assertEmpty($err->getMessage(), "Error message: ". $err->getMessage());
        }

        $this->assertNotFalse($output); //False on error, otherwise it's the raw results. You should be able to json_decode to read the response.
        $this->assertEquals(200, Testing::getLastHTTPResponseCode());
        //$this->assertJsonStringEqualsJsonString(""); //Compare against expected JSON object. You  could also do other tests.


    }

    public function testDeletePlayerGameList() {

        $token = $this->generateToken('Admin', 'Admin');
        $token = "\"" . $token . "\"";
        $body_contents = array();
        $body = json_encode($body_contents);
        $endpoint = "/playerglist/admin/1/1";

        try {
            $output = Testing::callAPIOverHTTP($endpoint, Methods::DELETE, $body, $token, Testing::JSON);
        } catch (\Exception $err) {
            $this->assertEmpty($err->getMessage(), "Error message: ". $err->getMessage());
        }

        $this->assertNotFalse($output); //False on error, otherwise it's the raw results. You should be able to json_decode to read the response.
        $this->assertEquals(200, Testing::getLastHTTPResponseCode());


    }
}