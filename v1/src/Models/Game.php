<?php
/**
 * Created by PhpStorm.
 * User: Nicholas Hayes
 * Date: 12/11/2017
 * Time: 10:40 AM
 */

namespace Gamer\Models;

use PHPUnit\Runner\Exception;
use Gamer\Utilities\DatabaseConnection;

class Game
{

    public $GameId;
    public $GameName;
    public $GameCompany;
    public $GameESRBRating;
    public $PlayerCounter;
    public $CreateYear;

    public function __construct()
    {

    }

    function jsonSerialize()
    {
        return
            array(
                "GameId" => $this->GameId,
                "GameName"=> $this->GameName,
                "GameCompany"=>$this->GameCompany,
                "GameESRBRating"=>$this->GameESRBRating,
                "PlayerCounter"=>$this->PlayerCount,
                "CreateYear"=>$this->CreateYear
            );
    }

    public function init(int $GameName, string $GameCompany, string $GameESRBRating, int $PlayerCount, string $CreateYear){

    $this->GameName = $GameName;
    $this->GameCompany = $GameCompany;
    $this->GameESRBRating = $GameESRBRating;
    $this->PlayerCount = $PlayerCount;
    $this->CreateYear = $CreateYear;

    $dbh = DatabaseConnection::getInstance();
    $stmt = $dbh->prepare("INSERT INTO `gamer_api`.`Games` (`GameName`, `GameESRBRating`, `GameCompany`, `PlayerCount`, `CreateYear`)
        VALUES (:GameName, :GameESRBRating, :GameCompany, :PlayerCount, :CreateYear)");

    $stmt->bindParam(":GameName", $GameName);
    $stmt->bindParam(":GameESRBRating", $GameESRBRating);
    $stmt->bindParam(":GameCompany", $GameCompany);
    $stmt->bindParam(":PlayerCount", $PlayerCount);
    $stmt->bindParam(":CreateYear", $CreateYear);

    $stmt->execute();

    $this->GameId = $dbh->lastInsertId('id');
}

    public function updateGame(int $GameId, int $GameName, string $GameCompany, string $GameESRBRating, int $PlayerCounter, string $CreateYear){
    $dbh = DatabaseConnection::getInstance();

    $stmtUpdate = $dbh->prepare("UPDATE `gamer_api`.`Games` SET 
            CreateYear = :CreateYear,
            GameCompany = :GameCompany,
            GameESRBRating = :GameESRBRating,
            GameName = :GameName,
            PlayerCount = :PlayerCount
            WHERE GameId = :GameId");

    $stmtUpdate->bindParam(":CreateYear", $CreateYear);
    $stmtUpdate->bindParam(":GameCompany", $GameCompany);
    $stmtUpdate->bindParam(":GameESRBRating", $GameESRBRating);
    $stmtUpdate->bindParam(":GameName", $GameName);
    $stmtUpdate->bindParam(":PlayerCount", $PlayerCounter);
    $stmtUpdate->bindParam(":GameId", $GameId);

    $stmtUpdate->execute();
}


    public static function getAllGames() {
    $dbh = DatabaseConnection::getInstance();

    $getAllGames = ' SELECT * FROM Games';
    $stmt = $dbh->prepare($getAllGames);
    $stmt->execute();

    $AllGames = $stmt->FetchAll(\PDO::FETCH_ASSOC);
    return $AllGames;
}

    public function getGameByGameID($GameId){
    $dbh = DatabaseConnection::getInstance();
    $stmt = $dbh->prepare("Select * From `gamer_api`.`Games` 
                                     WHERE GameId = :GameId");
    $stmt->bindParam(":GameId", $GameId);
    $stmt->execute();

    $AllGames = $stmt->FetchAll(\PDO::FETCH_CLASS, "Gamer\Models\Game");
    return $AllGames;
}

    public function deleteGameByGameID($GameId){
    $dbh = DatabaseConnection::getInstance();
    $stmtHandle = $dbh->prepare("DELETE FROM `gamer_api`.`Games`  WHERE GameId = :GameId");
    $stmtHandle->bindValue(":GameId", $GameId);
    $stmtHandle->execute();
}
}