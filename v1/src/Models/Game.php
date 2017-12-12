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
                "PlayerCounter"=>$this->PlayerCounter,
                "CreateYear"=>$this->CreateYear
            );
    }

    public function init(int $GameName, string $GameCompany = null, string $GameESRBRating = null, int $PlayerCounter = null, string $CreateYear = null){

    $this->GameName = $GameName;
    $this->GameCompany = $GameCompany;
    $this->GameESRBRating = $GameESRBRating;
    $this->PlayerCounter = $PlayerCounter;
    $this->CreateYear = $CreateYear;

    $dbh = DatabaseConnection::getInstance();
    $stmtCreate = $dbh->prepare("INSERT INTO `gamer_api`.`Games`(CreateYear, GameCompany, GameESRBRating, GameName, PlayerCount)
        VALUES(:CreateYear, :GameCompany, :GameESRBRating, :GameName, :PlayerCount)");


    $stmtCreate->bindParam(":CreateYear", $CreateYear);
    $stmtCreate->bindParam(":GameCompany", $GameCompany);
    $stmtCreate->bindParam(":GameESRBRating", $GameESRBRating);
    $stmtCreate->bindParam(":GameName", $GameName);
    $stmtCreate->bindParam(":PlayerCount", $PlayerCount);

    $stmtCreate->execute();


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