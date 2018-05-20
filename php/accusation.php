<?php

session_start();


include_once 'dbconnect.php';
include_once 'genKey';
$gameResult = '';


if($_SESSION[$gamemode]==='accuse'){
$db = dbConnect();


$stmt = $db->prepare("SELECT * FROM gameSolution WHERE GameKey = :gameKey AND :player = MurdereId AND :weapon = MurderWeaponId AND :room = MurderLocationId");


$player = filter_input(INPUT_POST, 'formPlayer');
$weapon = filter_input(INPUT_POST, 'formWeapon');
$room = filter_input(INPUT_POST, 'formRoom');


$binds = array(
    ":player" => $player,
    ":weapon" => $weapon,
    ":room" => $room,
    ":gameKey" => $gameKey);


      if ($stmt->execute($binds) && $stmt->rowCount() > 0) {
                $gameResults = 'Accusation Incorent';
                echo $gameResults; 
                $_SESSION['mode'] = 'dead';
                                    
            }
           
}      
               


?>