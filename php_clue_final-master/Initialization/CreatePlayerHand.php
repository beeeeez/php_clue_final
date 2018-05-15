<?php
include_once './ConnectDB.php';

$numberOfPlayers = 0;
$cardId = 0;
$cardsLeft = true;
        $conn = DBConnect();
                // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

try {
        $conn = DBConnect();
                // set the PDO error mode to exception
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //echo "Connected successfully"; 
                $stmt = $conn->prepare("Select Count(PlayerId) as PlayerCount from player WHERE GameKey = '1'");
                //print_r($db);
                //print_r($stmt);
                if($stmt->execute() && $stmt->rowCount() > 0){
                    $cnt = 0;
    
                    $results = $stmt->fetchALL(PDO::FETCH_ASSOC);
                    // print_r($results);;
                    $numberOfPlayers = $results[$cnt]['PlayerCount'];
                    
                } else{
                    echo"There are no Valid Players";
                } 
}
catch(PDOException $e)
            {
                
                echo "Connection failed: " . $e->getMessage();
                echo("<br>");
            }  
$players = array();

while(cardsLeft){
   
    $cardsLeft = false;
    
}
?>
      

