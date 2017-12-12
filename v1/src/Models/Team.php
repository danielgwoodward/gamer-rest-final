<?php
/**
 * Created by PhpStorm.
 * User: Nicholas Hayes
 * Date: 12/11/2017
 * Time: 9:30 AM
 */

namespace Team\Models;

use PHPUnit\Runner\Exception;
use Gamer\Utilities\DatabaseConnection;

class Team
{

    public $TeamId;
    public $TeamName;
    public $TeamOwner;
    public $TeamMainGameId;
    public $TeamSecondaryGameId;
    public $TeamCountry;

    public function __construct()
    {

    }

    function jsonSerialize()
    {
        return
            array(
                "TeamId" => $this->TeamId,
                "TeamName"=> $this->TeamName,
                "TeamOwner"=>   $this->TeamOwner,
                "TeamMainGameId"=>$this->TeamMainGameId,
                "TeamSecondaryGameId"=>$this->TeamSecondaryGameId,
                "TeamCountry"=>$this->TeamCountry
            );
    }

    public function init(string $TeamName, string $TeamOwner = null, string $TeamMainGameId = null, string $TeamSecondaryGameId = null, string $TeamCountry = null){

        $this->TeamName = $TeamName;
        $this->TeamOwner = $TeamOwner;
        $this->TeamMainGameId = $TeamMainGameId;
        $this->TeamSecondaryGameId = $TeamSecondaryGameId;
        $this->TeamCountry = $TeamCountry;

        $dbh = DatabaseConnection::getInstance();
        $stmtCreate = $dbh->prepare("INSERT INTO `gamer_api`.`Teams`(TeamCountry, TeamMainGameId, TeamName, TeamOwner, TeamSecondaryGameId)
        VALUES(:TeamCountry, :TeamMainGameId, :TeamName, :TeamOwner, :TeamSecondaryGameId)");


        $stmtCreate->bindParam(":TeamCountry", $TeamCountry);
        $stmtCreate->bindParam(":TeamMainGameId", $TeamMainGameId);
        $stmtCreate->bindParam(":TeamName", $TeamName);
        $stmtCreate->bindParam(":TeamOwner", $TeamOwner);
        $stmtCreate->bindParam(":TeamSecondaryGameId", $TeamSecondaryGameId);

        $stmtCreate->execute();


        $this->TeamId = $dbh->lastInsertId('id');
    }

    public function updateTeam(int $TeamId, string $TeamName, string $TeamOwner, string $TeamMainGameId, string $TeamSecondaryGameId, string $TeamCountry){
        $dbh = DatabaseConnection::getInstance();

        $stmtUpdate = $dbh->prepare("UPDATE `gamer_api`.`Teams` SET 
            TeamCountry = :TeamCountry,
            TeamMainGameId = :TeamMainGameId,
            TeamName = :TeamName,
            TeamOwner = :TeamOwner,
            TeamSecondaryGameId = :TeamSecondaryGameId
            WHERE TeamId = :TeamId");

        $stmtUpdate->bindParam(":TeamCountry", $TeamCountry);
        $stmtUpdate->bindParam(":TeamMainGameId", $TeamMainGameId);
        $stmtUpdate->bindParam(":TeamName", $TeamName);
        $stmtUpdate->bindParam(":TeamOwner", $TeamOwner);
        $stmtUpdate->bindParam(":TeamSecondaryGameId", $TeamSecondaryGameId);
        $stmtUpdate->bindParam(":TeamId", $TeamId);

        $stmtUpdate->execute();
    }


    public static function getAllTeams() {
        $dbh = DatabaseConnection::getInstance();

        $getAllTeams = ' SELECT * FROM Teams';
        $stmt = $dbh->prepare($getAllTeams);
        $stmt->execute();

        $AllTeams = $stmt->FetchAll(\PDO::FETCH_ASSOC);
        return $AllTeams;
    }

    public function getTeamByTeamID($TeamId){
        $dbh = DatabaseConnection::getInstance();
        $stmtGetAll = $dbh->prepare("Select * From `gamer_api`.`Teams` 
                                     WHERE TeamId = :TeamId");
        $stmtGetAll->bindParam(":TeamId", $TeamId);
        $stmtGetAll->execute();

        $AllGamers = $stmtGetAll->FetchAll(\PDO::FETCH_CLASS, "Team\Models\Team");
        return $AllGamers;
    }

    public function deleteTeamByTeamID($TeamId){
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("DELETE FROM `gamer_api`.`Teams`  WHERE TeamId = :TeamId");
        $stmtHandle->bindValue(":TeamId", $TeamId);
        $stmtHandle->execute();
    }

}