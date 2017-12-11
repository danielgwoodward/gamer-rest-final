<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/11/17
 * Time: 3:32 PM
 */

namespace Gamer\Models;

use Gamer\Utilities\DatabaseConnection;


class MatchHistory implements \JsonSerializable
{

    public $AwayTeamId;
    public $HomeTeamId;
    public $MatchDate;
    public $MatchId;
    public $WinningTeamId;


    public function __construct()
    {

    }

    function jsonSerialize()
    {
        return
            array(
                "MatchId"=>$this->MatchId,
                "AwayTeamId" => $this->AwayTeamId,
                "HomeTeamId"=> $this->HomeTeamId,
                "MatchDate"=>   $this->MatchDate,
                "WinningTeamId"=>$this->WinningTeamId
            );
    }


    public function init(int $AwayTeamId, int $HomeTeamId, string $MatchDate, int $WinningTeamId){


        $this->AwayTeamId = $AwayTeamId;
        $this->HomeTeamId = $HomeTeamId;
        $this->MatchDate = $MatchDate;
        $this->WinningTeamId = $WinningTeamId;


        $dbh = DatabaseConnection::getInstance();
        $stmtCreate = $dbh->prepare("INSERT INTO `gamer_api`.`MatchHistory`(AwayTeamId,HomeTeamId,MatchDate,WinningTeamId)
        VALUES(:AwayTeamId, :HomeTeamId, :MatchDate, :WinningTeamId)");


        $stmtCreate->bindParam(":AwayTeamId", $AwayTeamId);
        $stmtCreate->bindParam(":HomeTeamId", $HomeTeamId);
        $stmtCreate->bindParam(":MatchDate", $MatchDate);
        $stmtCreate->bindParam(":WinningTeamId", $WinningTeamId);

        $stmtCreate->execute();


        $this->MatchId = $dbh->lastInsertId('id');

    }

    public function updateMatch(int $MatchId, int $AwayTeamId, int $HomeTeamId, string $MatchDate, int $WinningTeamId){
        $dbh = DatabaseConnection::getInstance();

        $stmtUpdate = $dbh->prepare("UPDATE `gamer_api`.`MatchHistory` SET 
            AwayTeamId = :AwayTeamId,
            HomeTeamId = :HomeTeamId,
            MatchDate = :MatchDate,
            WinningTeamId = :WinningTeamId
            WHERE MatchId = :MatchId");



        $stmtUpdate->bindParam(":AwayTeamId", $AwayTeamId);
        $stmtUpdate->bindParam(":HomeTeamId", $HomeTeamId);
        $stmtUpdate->bindParam(":MatchDate", $MatchDate);
        $stmtUpdate->bindParam(":WinningTeamId", $WinningTeamId);
        $stmtUpdate->bindParam(":MatchId", $MatchId);

        $stmtUpdate->execute();
    }

    public static function getAllMatches() {
        $dbh = DatabaseConnection::getInstance();

        $getAllMatches = ' SELECT * FROM MatchHistory';
        $stmt = $dbh->prepare($getAllMatches);
        $stmt->execute();

        $AllMatches = $stmt->FetchAll(\PDO::FETCH_ASSOC);
        return $AllMatches;
    }

    public function getMatchByMatchID($MatchId){
        $dbh = DatabaseConnection::getInstance();
        $stmtGetAll = $dbh->prepare("Select * From `gamer_api`.`MatchHistory` 
                                     WHERE MatchId = :MatchId");
        $stmtGetAll->bindParam(":MatchId", $MatchId);
        $stmtGetAll->execute();

        $AllMatches = $stmtGetAll->FetchAll(\PDO::FETCH_CLASS, "Gamer\Models\MatchHistory");
        return $AllMatches;
    }

    public function deleteMatchByMatchID($MatchId){
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("DELETE FROM `gamer_api`.`MatchHistory`  WHERE MatchId = :MatchId");
        $stmtHandle->bindValue(":MatchId", $MatchId);
        $stmtHandle->execute();
    }


}