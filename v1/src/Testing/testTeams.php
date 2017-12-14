<?php
/**
 * Created by PhpStorm.
 * User: Nicholas Hayes
 * Date: 12/11/2017
 * Time: 10:02 AM
 */
namespace Gamer\Testing;
use Gamer\Controllers\TokensController;
use Gamer\Http\Methods;
use \PHPUnit\Framework\TestCase;
use \Gamer\Http\StatusCodes;
use Gamer\Utilities\Testing;
class testTeams extends TestCase {
    private function generateToken($username, $password)
    {
        $tokenController = new TokensController();
        return $tokenController->buildToken($username, $password);
    }
    public function testAdminNULLPUT() //Test Faculty with NULL PUT Body
    {
        $token = $this->generateToken('Admin', 'Admin');
        $token = "\"".$token."\"";
        $json = NULL;
        $body = json_encode($json);
        $endpoint = "/teams";
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
        $token = "\"".$token."\"";
        $json = NULL;
        $body = json_encode($json);
        $endpoint = "/teams";
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
        $token = "\"".$token."\"";
        $json = array(
            "EXTRA" => "NODONTDOTHAT",
            "TeamName"=> "TheSpicyNoodles",
            "TeamOwner" => "1",
            "TeamMainGameId" => "1",
            "TeamSecondaryGameId" =>"2",
            "TeamCountry" => "Canada"
        );
        $body = json_encode($json);
        $endpoint = "/teams";
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
        $token = "\"".$token."\"";
        $json = array(
            "TeamName"=> "TheSpicyNoodles",
            "TeamOwner" => "1",
            "TeamMainGameId" => "1",
            "TeamSecondaryGameId" =>"2",
            "TeamCountry" => "Canada"
        );
        $body = json_encode($json);
        $endpoint = "/teams";
        try {
            $output = Testing::callAPIOverHTTP($endpoint, Methods::POST, $body, $token, Testing::JSON);
        } catch (\Exception $err) {
            $this->assertEmpty($err->getMessage(), "Error message: ". $err->getMessage());
        }
        $this->assertNotFalse($output);
        $this->assertEquals(StatusCodes::CREATED, Testing::getLastHTTPResponseCode());
        //TODO: Need to check the JSON string that is returned from a create
    }
    public function testAdminPut() //Admin should be able to PUT
    {
        $token = $this->generateToken('Admin', 'Admin');
        $token = "\"".$token."\"";
        $json = array(
            "TeamId"=> "1",
            "TeamName"=> "TheSpicyNoodles",
            "TeamOwner" => "1",
            "TeamMainGameId" => "1",
            "TeamSecondaryGameId" =>"2",
            "TeamCountry" => "Canada"
        );
        $body = json_encode($json);
        $endpoint = "/teams";
        try {
            $output = Testing::callAPIOverHTTP($endpoint, Methods::PUT, $body, $token, Testing::JSON);
        } catch (\Exception $err) {
            $this->assertEmpty($err->getMessage(), "Error message: ". $err->getMessage());
        }
        $this->assertNotFalse($output);
        $this->assertEquals(StatusCodes::OK, Testing::getLastHTTPResponseCode());
    }
    public function testGetTeamId() {
        $token = $this->generateToken("User", "User");
        $token = "\"".$token."\"";
        $body_contents = array();
        $body = json_encode($body_contents);
        $endpoint = "/teams/1";
        try {
            $output = Testing::callAPIOverHTTP($endpoint, Methods::GET, $body, $token, Testing::JSON);
        } catch (\Exception $err) {
            $this->assertEmpty($err->getMessage(), "Error message: ". $err->getMessage());
        }
        $this->assertNotFalse($output); //False on error, otherwise it's the raw results. You should be able to json_decode to read the response.
        $this->assertEquals(200, Testing::getLastHTTPResponseCode());
    }
    //TODO: Create a testGetTeamIdAsAdmin
    public function testGetAllTeams()
    {
        $token = $this->generateToken("User", "User");
        $token = "\"".$token."\"";
        $body_contents = array();
        $body = json_encode($body_contents);
        $endpoint = "/teams";
        try {
            $output = Testing::callAPIOverHTTP($endpoint, Methods::GET, $body, $token, Testing::JSON);
        } catch (\Exception $err) {
            $this->assertEmpty($err->getMessage(), "Error message: ". $err->getMessage());
        }
        $this->assertNotFalse($output); //False on error, otherwise it's the raw results. You should be able to json_decode to read the response.
        $this->assertEquals(200, Testing::getLastHTTPResponseCode());
        //$this->assertJsonStringEqualsJsonString(""); //Compare against expected JSON object. You  could also do other tests.
        //TODO: Find a way to compare the returned JSON string to what is in the database. TimeFrame has an example of how to do this.
        //TODO: All of the unit tests need a regular user version and a faculty version.
    }
    public function testDeleteGamerId() {
        $token = $this->generateToken("User", "User");
        $token = "\"".$token."\"";
        $body_contents = array();
        $body = json_encode($body_contents);
        $endpoint = "/teams/admin/10";
        try {
            $output = Testing::callAPIOverHTTP($endpoint, Methods::DELETE, $body, $token, Testing::JSON);
        } catch (\Exception $err) {
            $this->assertEmpty($err->getMessage(), "Error message: ". $err->getMessage());
        }
        $this->assertNotFalse($output); //False on error, otherwise it's the raw results. You should be able to json_decode to read the response.
        $this->assertEquals(403, Testing::getLastHTTPResponseCode());
        //TODO: Create a testDeleteGamerIdAsFaculty
    }
}