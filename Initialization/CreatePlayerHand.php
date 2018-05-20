<?php
//include_once './ConnectDB.php';
//$gameKey = "1";
include_once 'dbconnect.php'; 
$gameKey = $_SESSION["gameKey"];
$numberOfPlayers = 0;
//$cardId = 0;
$cardsLeft = true;
        $conn = getDatabase();
                // set the PDO error mode to exception
        //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
        $conn = getDatabase();
                // set the PDO error mode to exception
                //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //echo "Connected successfully"; 
                $stmt = $conn->prepare("Select Count(PlayerId) as PlayerCount from player WHERE GameKey = '$gameKey'");
                //print_r($db);
                //print_r($stmt);
                if($stmt->execute() && $stmt->rowCount() > 0){
                    $cnt = 0;
                    $_SESSION['string'] = 'poop4';

                    $results = $stmt->fetchALL(PDO::FETCH_ASSOC);
                    // print_r($results);;
                    $numberOfPlayers = $results[$cnt]['PlayerCount'];
                    
                } else{
                    $_SESSION['string'] = 'error 5';

                    echo"There are no Valid Players";
                } 
}
catch(PDOException $e)
            {
                
                echo "Connection failed: " . $e->getMessage();
                echo("<br>");
            }  
$players = array();

try {
        $conn = getDatabase();
                // set the PDO error mode to exception
                //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //echo "Connected successfully"; 
                $stmt = $conn->prepare("Select * from player WHERE GameKey = '$gameKey'");
                //print_r($db);
                //print_r($stmt);
                if($stmt->execute() && $stmt->rowCount() > 0){
                    $cnt = 0;
                    $_SESSION['string'] = 'poop5';
                    $results = $stmt->fetchALL(PDO::FETCH_ASSOC);
                    // print_r($results);;
                    while($cnt<$numberOfPlayers){
                        $players[] = $results[$cnt]['PlayerId'];
                        $cnt++;
                    }

                    
                } else{
                    $_SESSION['string'] = 'error6';
                    echo "There are no Valid Players";
                } 
}
catch(PDOException $e)
            {
                
                echo "Connection failed: " . $e->getMessage();
                echo("<br>");
            }  

   $cards = array();         
            try {
        $conn = getDatabase();
                // set the PDO error mode to exception
                //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //echo "Connected successfully"; 
                $stmt = $conn->prepare("Select c.* from cards c
                                        WHERE CardID Not IN(
                                        Select MurdererId FROM gamesolution WHERE GameKey = '$gameKey'
                                        UNION
                                        Select MurderLocationId FROM gamesolution WHERE GameKey = '$gameKey'
                                        UNION
                                        Select MurderWeaponId FROM gamesolution WHERE GameKey = '$gameKey'
                )");
                //print_r($db);
                //print_r($stmt);
                if($stmt->execute() && $stmt->rowCount() > 0){
                    $cnt = 0;
                    $_SESSION['string'] = 'poop6';
                    $results = $stmt->fetchALL(PDO::FETCH_ASSOC);
                    // print_r($results);;
                    
                    $size = sizeof($results);
                    while($cnt<$size){
                        $cards[] = $results[$cnt]['CardId'];
                        $cnt++;
                    }

                    
                } else{
                    $_SESSION['string'] = 'error 7';
                    echo "There are no Valid cards";
                } 
}
catch(PDOException $e)
            {
                
                echo "Connection failed: " . $e->getMessage();
                echo("<br>");
            }  
            
            shuffle($cards);
//echo "The Card is " + $cards[3];
        $handcnt = 0;
        $playercnt = 0;
        $playerId = 0;
        $cardId = 0;
        $size = sizeof($cards);
        while($handcnt < $size){
            $cardId = $cards[$handcnt];
            $playerId = $players[$playercnt];
            //echo "PlayerId $playerId cardid $cardId";
                echo("<br>");
         try {
                $conn = getDatabase();
                $stmt = $conn->prepare("INSERT INTO `playerhand`(`GameKey`, `PlayerId`, `CardId`) VALUES ('$gameKey','$playerId','$cardId')");
                
                if($stmt->execute()){
                   $_SESSION['string'] = 'poop7'; 
                }else{
                    $_SESSION['string'] = 'error 8';
                }
            }
            catch(PDOException $e)
            {
                echo "Connection failed: " . $e->getMessage();
                echo("<br>");
            }
            $playercnt++;
            //echo "Playercnt $playercnt Num Players $numberOfPlayers";
                echo("<br>");
            if($playercnt >= $numberOfPlayers){
                $playercnt = 0;
                //echo"reset";
            }
            $handcnt++;
        }
?>
      

