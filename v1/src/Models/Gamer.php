<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/10/17
 * Time: 1:53 PM
 */

namespace Gamer\Models;

use Gamer\Utilities\DatabaseConnection;


class Gamer implements \JsonSerializable
{

    public $GamerId;
    public $GamerTag;
    public $TeamId;
    public $MainGamePlayedId;
    public $Rank;



    public function __construct()
    {

    }

    function jsonSerialize()
    {
        return
            array(
                "GamerId" => $this->GamerId,
                "GamerTag"=> $this->GamerTag,
                "TeamId"=>   $this->TeamId,
                "MainGamePlayedId"=>$this->MainGamePlayedId,
                "Rank"=>$this->Rank
            );
    }

    public function init(string $GamerTag, int $TeamId = null, int $MainGamePlayedId = null, string $Rank = null){


        $this->GamerTag = $GamerTag;
        $this->TeamId = $TeamId;
        $this->MainGamePlayedId = $MainGamePlayedId;
        $this->Rank = $Rank;


        $dbh = DatabaseConnection::getInstance();
        $stmtCreate = $dbh->prepare("INSERT INTO `gamer_api`.`Gamers`(GamerTag,TeamId,MainGamePlayedId,Rank)
        VALUES(:GamerTag, :TeamId, :MainGamePlayedId, :Rank)");


        $stmtCreate->bindParam(":GamerTag", $GamerTag);
        $stmtCreate->bindParam(":TeamId", $TeamId);
        $stmtCreate->bindParam(":MainGamePlayedId", $MainGamePlayedId);
        $stmtCreate->bindParam(":Rank", $Rank);

        $stmtCreate->execute();


        $this->GamerId = $dbh->lastInsertId('id');

    }

    public function updateGamer(int $GamerId, string $GamerTag, int $TeamId, int $MainGamePlayedId, string $Rank){
        $dbh = DatabaseConnection::getInstance();

        $stmtUpdate = $dbh->prepare("UPDATE `gamer_api`.`Gamers` SET 
            GamerTag = :GamerTag,
            TeamId = :TeamId,
            MainGamePlayedId = :MainGamePlayedId,
            Rank = :Rank
            WHERE GamerId = :GamerId");



        $stmtUpdate->bindParam(":GamerTag", $GamerTag);
        $stmtUpdate->bindParam(":TeamId", $TeamId);
        $stmtUpdate->bindParam(":MainGamePlayedId", $MainGamePlayedId);
        $stmtUpdate->bindParam(":Rank", $Rank);
        $stmtUpdate->bindParam(":GamerId", $GamerId);

        $stmtUpdate->execute();
    }


    public static function getAllGamers() {
        $dbh = DatabaseConnection::getInstance();

        $getAllGamers = ' SELECT * FROM Gamers';
        $stmt = $dbh->prepare($getAllGamers);
        $stmt->execute();

        $AllGamers = $stmt->FetchAll(\PDO::FETCH_ASSOC);
        return $AllGamers;
    }

    public function getGamerByGamerID($GamerId){
        $dbh = DatabaseConnection::getInstance();
        $stmtGetAll = $dbh->prepare("Select * From `gamer_api`.`Gamers` 
                                     WHERE GamerId = :GamerId");
        $stmtGetAll->bindParam(":GamerId", $GamerId);
        $stmtGetAll->execute();

        $AllGamers = $stmtGetAll->FetchAll(\PDO::FETCH_CLASS, "Gamer\Models\Gamer");
        return $AllGamers;
    }

    public function deleteGamerByGamerID($GamerId){
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("DELETE FROM `gamer_api`.`Gamers`  WHERE GamerId = :GamerId");
        $stmtHandle->bindValue(":GamerId", $GamerId);
        $stmtHandle->execute();
    }
}