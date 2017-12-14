<?php
/**
 * Created by PhpStorm.
 * User: Dan
 * Date: 12/11/17
 * Time: 6:31 PM
 */

namespace Gamer\Models;

use Gamer\Utilities\DatabaseConnection;
use PHPUnit\Runner\Exception;


class PlayerGamesList  implements \JsonSerializable
{
    public $GameId;
    public $GamerId;


    public function __construct()
    {

    }

    function jsonSerialize()
    {
        return
            array(
                "GamerId" => $this->GamerId,
                "GameId"=> $this->GameId
            );
    }


    public function init(int $GamerId, int $GameId){


    $this->GamerId = $GamerId;
    $this->GameId = $GameId;

    $dbh = DatabaseConnection::getInstance();
    $stmtCreate = $dbh->prepare("INSERT INTO `gamer_api`.`PlayerGamesList`(GamerId,GameId)
        VALUES(:GamerId, :GameId)");


    $stmtCreate->bindParam(":GamerId", $GamerId);
    $stmtCreate->bindParam(":GameId", $GameId);

    $stmtCreate->execute();

    }

    public function updatePlayerGList(int $GamerId, int $GameId){
        $dbh = DatabaseConnection::getInstance();

        $stmtUpdate = $dbh->prepare("UPDATE `gamer_api`.`PlayerGamesList` SET 
            WHERE GamerId = :GamerId
            AND   GameId =  :GameId");

        $stmtUpdate->bindParam(":GameId", $GameId);
        $stmtUpdate->bindParam(":GamerId", $GamerId);

        $stmtUpdate->execute();
    }

    public static function getPlayerGList() {
        $dbh = DatabaseConnection::getInstance();

        $getAllPlayerGList = ' SELECT * FROM PlayerGamesList';
        $stmt = $dbh->prepare($getAllPlayerGList);
        $stmt->execute();

        $AllPlayerGList = $stmt->FetchAll(\PDO::FETCH_ASSOC);
        return $AllPlayerGList;
    }

    public function getGamerPlayerGList($GamerId){
        $dbh = DatabaseConnection::getInstance();
        $stmtGetAll = $dbh->prepare("Select * From `gamer_api`.`PlayerGamesList` 
                                     WHERE GamerId = :GamerId");
        $stmtGetAll->bindParam(":GamerId", $GamerId);
        $stmtGetAll->execute();

        $AllGamers = $stmtGetAll->FetchAll(\PDO::FETCH_CLASS, "Gamer\Models\PlayerGamesList");
        return $AllGamers;
    }

    public function deletePlayerGList($GamerId, $GameId){
        $dbh = DatabaseConnection::getInstance();
        $stmtHandle = $dbh->prepare("DELETE FROM `gamer_api`.`PlayerGamesList`  WHERE GamerId = :GamerId AND GameId = :GameId");
        $stmtHandle->bindValue(":GamerId", $GamerId);
        $stmtHandle->bindValue(":GameId", $GameId);
        $stmtHandle->execute();
    }

}