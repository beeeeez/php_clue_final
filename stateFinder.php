<?php

include 'drawMode.php';

function waitingCheck() {
    $results = array();
    $db = getDatabase();
    $stmt = $db->prepare("SELECT TurnID, NumberOfPlayers FROM turn INNER JOIN game on turn.gameKey = game.gameKey where turn.gameKey = :gameKey");
    $binds = array(
        ":gameKey" => $_SESSION['gameKey'],
    );
    if ($stmt->execute($binds) > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $x) {
            if ($x["TurnID"] != $_SESSION["PlayerID"]) {
                $_SESSION["mode"] = "wait";
            } else if ($x["TurnID"] == $_SESSION["PlayerID"] && $_SESSION['mode'] == "wait" && $_SESSION['mode'] != "suggest" && $_SESSION['mode'] != "move" && $_SESSION['mode'] != "accuse" && $_SESSION['mode'] != "dead") {
                $_SESSION["mode"] = "move";
            }
        }// end of waiting check
    }
}

function whereamI() {
    $results = array();
    $db = getDatabase();
    $stmt = $db->prepare("SELECT * from characters where PlayerID = :playerid and gamekey = :gameKey");
    $binds = array(
        ":playerid" => $_SESSION['PlayerID'],
        ":gameKey" => $_SESSION['gameKey'],
    );
    if ($stmt->execute($binds) > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $x) {
            $_SESSION['xCoord'] = $x["xCoord"];
            $_SESSION['yCoord'] = $x["YCoord"];
        }
        $room = roomCheck($_SESSION['xCoord'], $_SESSION['yCoord']);
        if ($room != "none") {
            $_SESSION['comingOut'] = true;
        }
    }
}

function findState() {
    waitingCheck();
    if ($_SESSION['mode'] == "wait") {

        waitDraw();
    } else if ($_SESSION['mode'] == "move") {
        if (isset($_POST['updateX']) && $_POST['dice1'] == 0) {
            $_SESSION['mode'] = "suggest";
            $_SESSION['prevRoom'] = "none";
            // suggestDraw();
        } else {
            moveDraw();
            echo "fuck8";
            
        }
    } else if ($_SESSION['mode'] == "suggest") {
        drawSuggest();
       
        
    } else if ($_SESSION['mode'] == "accuse") {
        if(isset($_POST['showCardId']) && isset($_POST['showCharacter'])){
            echo $_POST['showCharacter'];
            echo " has shown you this card: <br/>";
            echo '<img src="./images/';
            echo $_POST['showCardId'];
            echo '" /><br />';
        }
        accuseDraw();
    } else if ($_SESSION['mode'] == "dead") {
         changeTurnId();
        echo "<script>location.reload();</script>";
    }
}


function changeTurnId(){
    echo "fuck0";
    foreach($_SESSION['playerList'] as $key=>$value){
        if($key == 0){
            
            $firstPlayer = $value;
            echo "<br>";
            echo $value;
            echo "<br>";
            echo $firstPlayer;
        }
            if ($value == $_SESSION['PlayerID']){
                $counter = $key;
                echo "<br>";
                echo $counter;
            }            
        }
        $counter++;
        echo "<br>";
        echo $counter;
        if ($counter == $_SESSION['numberofPlayers']){
            $turnDestination = $firstPlayer;
            echo "<br>";
            echo $turnDestination;
            echo "<br>";
        }
        else{
            $turnDestination = $_SESSION['PlayerID'] +1;
            echo "<br>";
            echo $turnDestination;
        }
        $results = array();
        $db = getDatabase();
        echo "fuck6";
            $stmt = $db->prepare("update turn set turnid = :turnid where gameKey = :gameKey");
            $binds = array(
                ":turnid" => $turnDestination,
                ":gameKey" => $_SESSION['gameKey'],
            );
            if ($stmt->execute($binds) > 0) {
                echo "fuck6";
                $_SESSION['mode'] = "wait";
            }
            
    
}

function movementCheck() {

    if ($_SESSION['mode'] == "move" && isset($_POST['updateX']) && isset($_POST['updateY'])) {
        whereami();
        $room = roomCheck($_SESSION['xCoord'], $_SESSION['yCoord']);
        if ($room != "none") {
            $_SESSION['comingOut'] = true;
            $_SESSION['prevRoom'] = $room;
        }

        $room = doorwayCheck();
        //  
        //  
        if (isset($_SESSION['comingOut']) && !isset($_POST['secretPass'])) {
            unset($_SESSION['comingOut']);

            $results = array();
            $db = getDatabase();
            $stmt = $db->prepare("update characters set xCoord = :xCoord, YCoord = :yCoord where playerid = :playerid and gameKey = :gameKey");
            $binds = array(
                ":xCoord" => $_POST['updateX'],
                ":yCoord" => $_POST['updateY'],
                ":playerid" => $_SESSION['PlayerID'],
                ":gameKey" => $_SESSION['gameKey'],
            );
            if ($stmt->execute($binds) > 0) {
                unset($_POST['updateX']);
                unset($_POST['updateY']);

                if ($_POST['dice2'] > 0) {
                    $_POST['dice2'] = $_POST['dice2'] - 1;
                } else if ($_POST['dice1'] > 0) {
                    $_POST['dice1'] = $_POST['dice1'] - 1;
                } else {
                    $_SESSION['mode'] = 'suggest';
                }
            }
        } else if ($room != "none" && $room != $_SESSION['prevRoom']) {

            $counter = 0;
            $results = array();
            $db = getDatabase();
            $stmt = $db->prepare("SELECT * from characters where gamekey = :gameKey");
            $binds = array(
                ":gameKey" => $_SESSION['gameKey'],
            );
            if ($stmt->execute($binds) > 0) {
                $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($results as $x) {
                    $check = roomSlotCheck($x['xCoord'], $x['YCoord'], $room);
                    if ($check == true) {
                        $counter++;
                    }
                }

                moveRoom($room, $counter);
            }
        } else {

            $results = array();
            $db = getDatabase();
            $stmt = $db->prepare("update characters set xCoord = :xCoord, YCoord = :yCoord where playerid = :playerid and gameKey = :gameKey");
            $binds = array(
                ":xCoord" => $_POST['updateX'],
                ":yCoord" => $_POST['updateY'],
                ":playerid" => $_SESSION['PlayerID'],
                ":gameKey" => $_SESSION['gameKey'],
            );
            if ($stmt->execute($binds) > 0) {
                if ($_POST['dice2'] > 0) {
                    $_POST['dice2'] = $_POST['dice2'] - 1;
                } else if ($_POST['dice1'] > 0) {
                    $_POST['dice1'] = $_POST['dice1'] - 1;
                } else {
                    $_SESSION['mode'] = 'suggest';
                }
            }
        }
    }
}

function roomSlotCheck($xC, $yC, $room) {
    $check = false;
    if ($room == "study") {
        if ($xC == 2 && $yC == 2) {//study
            $check = true;
        }
        if ($xC == 3 && $yC == 2) {
            $check = true;
        }
        if ($xC == 4 && $yC == 2) {
            $check = true;
        }
        if ($xC == 2 && $yC == 4) {
            $check = true;
        }
        if ($xC == 3 && $yC == 4) {
            $check = true;
        }
        if ($xC == 4 && $yC == 4) {
            $check = true;
        }//study
    }

    if ($room == "hall") {

        if ($xC == 11 && $yC == 3) {//hall
            $check = true;
        }
        if ($xC == 12 && $yC == 3) {
            $check = true;
        }
        if ($xC == 13 && $yC == 3) {
            $check = true;
        }
        if ($xC == 11 && $yC == 5) {
            $check = true;
        }
        if ($xC == 12 && $yC == 5) {
            $check = true;
        }
        if ($xC == 13 && $yC == 5) {
            $check = true;
        }//hall
    }
    if ($room == "lounge") {

        if ($xC == 19 && $yC == 2) {//lounge
            $check = true;
        }
        if ($xC == 20 && $yC == 2) {
            $check = true;
        }
        if ($xC == 21 && $yC == 2) {
            $check = true;
        }
        if ($xC == 19 && $yC == 4) {
            $check = true;
        }
        if ($xC == 20 && $yC == 4) {
            $check = true;
        }
        if ($xC == 21 && $yC == 4) {
            $check = true;
        }//lounge
    }
    if ($room == "library") {

        if ($xC == 3 && $yC == 8) {//library
            $check = true;
        }
        if ($xC == 4 && $yC == 8) {
            $check = true;
        }
        if ($xC == 5 && $yC == 8) {
            $check = true;
        }
        if ($xC == 3 && $yC == 10) {
            $check = true;
        }
        if ($xC == 4 && $yC == 10) {
            $check = true;
        }
        if ($xC == 4 && $yC == 10) {
            $check = true;
        }//library
    }
    if ($room == "billiard") {

        if ($xC == 2 && $yC == 14) {//billiard
            $check = true;
        }
        if ($xC == 3 && $yC == 14) {
            $check = true;
        }
        if ($xC == 4 && $yC == 14) {
            $check = true;
        }
        if ($xC == 2 && $yC == 16) {
            $check = true;
        }
        if ($xC == 3 && $yC == 16) {
            $check = true;
        }
        if ($xC == 4 && $yC == 16) {
            $check = true;
        }//billiard
    }
    if ($room == "dining") {

        if ($xC == 19 && $yC == 12) {//dining
            $check = true;
        }
        if ($xC == 20 && $yC == 12) {
            $check = true;
        }
        if ($xC == 21 && $yC == 12) {
            $check = true;
        }
        if ($xC == 19 && $yC == 14) {
            $check = true;
        }
        if ($xC == 20 && $yC == 14) {
            $check = true;
        }
        if ($xC == 21 && $yC == 14) {
            $check = true;
        }//dining 
    }
    if ($room == "conservatory") {
        if ($xC == 2 && $yC == 23) {//conservatory
            $check = true;
        }
        if ($xC == 3 && $yC == 23) {
            $check = true;
        }
        if ($xC == 4 && $yC == 23) {
            $check = true;
        }
        if ($xC == 2 && $yC == 24) {
            $check = true;
        }
        if ($xC == 3 && $yC == 24) {
            $check = true;
        }
        if ($xC == 4 && $yC == 24) {
            $check = true;
        }//conservatory
    }
    if ($room == "ballroom") {

        if ($xC == 10 && $yC == 19) {//ballroom
            $check = true;
        }
        if ($xC == 11 && $yC == 19) {
            $check = true;
        }
        if ($xC == 12 && $yC == 19) {
            $check = true;
        }
        if ($xC == 10 && $yC == 21) {
            $check = true;
        }
        if ($xC == 11 && $yC == 21) {
            $check = true;
        }
        if ($xC == 12 && $yC == 21) {
            $check = true;
        }//ballroom
    }
    if ($room == "kitchen") {


        if ($xC == 20 && $yC == 20) {//kitchen
            $check = true;
        }
        if ($xC == 21 && $yC == 20) {
            $check = true;
        }
        if ($xC == 22 && $yC == 20) {
            $check = true;
        }
        if ($xC == 20 && $yC == 22) {
            $check = true;
        }
        if ($xC == 21 && $yC == 22) {
            $check = true;
        }
        if ($xC == 22 && $yC == 22) {
            $check = true;
        }//kitchen
    }
    return $check;
}

function roomCheck($xC, $yC) {
    $check = "none";

    if ($xC == 2 && $yC == 2) {//study
        $check = "study";
    }
    if ($xC == 3 && $yC == 2) {
        $check = "study";
    }
    if ($xC == 4 && $yC == 2) {
        $check = "study";
    }
    if ($xC == 2 && $yC == 4) {
        $check = "study";
    }
    if ($xC == 3 && $yC == 4) {
        $check = "study";
    }
    if ($xC == 4 && $yC == 4) {
        $check = "study";
    }//study


    if ($xC == 11 && $yC == 3) {//hall
        $check = "hall";
    }
    if ($xC == 12 && $yC == 3) {
        $check = "hall";
    }
    if ($xC == 13 && $yC == 3) {
        $check = "hall";
    }
    if ($xC == 11 && $yC == 5) {
        $check = "hall";
    }
    if ($xC == 12 && $yC == 5) {
        $check = "hall";
    }
    if ($xC == 13 && $yC == 5) {
        $check = "hall";
    }//hall


    if ($xC == 19 && $yC == 2) {//lounge
        $check = "lounge";
    }
    if ($xC == 20 && $yC == 2) {
        $check = "lounge";
    }
    if ($xC == 21 && $yC == 2) {
        $check = "lounge";
    }
    if ($xC == 19 && $yC == 4) {
        $check = "lounge";
    }
    if ($xC == 20 && $yC == 4) {
        $check = "lounge";
    }
    if ($xC == 21 && $yC == 4) {
        $check = "lounge";
    }//lounge


    if ($xC == 3 && $yC == 8) {//library
        $check = "library";
    }
    if ($xC == 4 && $yC == 8) {
        $check = "library";
    }
    if ($xC == 5 && $yC == 8) {
        $check = "library";
    }
    if ($xC == 3 && $yC == 10) {
        $check = "library";
    }
    if ($xC == 4 && $yC == 10) {
        $check = "library";
    }
    if ($xC == 4 && $yC == 10) {
        $check = "library";
    }//library


    if ($xC == 2 && $yC == 14) {//billiard
        $check = "billiard";
    }
    if ($xC == 3 && $yC == 14) {
        $check = "billiard";
    }
    if ($xC == 4 && $yC == 14) {
        $check = "billiard";
    }
    if ($xC == 2 && $yC == 16) {
        $check = "billiard";
    }
    if ($xC == 3 && $yC == 16) {
        $check = "billiard";
    }
    if ($xC == 4 && $yC == 16) {
        $check = "billiard";
    }//billiard

    if ($xC == 19 && $yC == 12) {//dining
        $check = "dining";
    }
    if ($xC == 20 && $yC == 12) {
        $check = "dining";
    }
    if ($xC == 21 && $yC == 12) {
        $check = "dining";
    }
    if ($xC == 19 && $yC == 14) {
        $check = "dining";
    }
    if ($xC == 20 && $yC == 14) {
        $check = "dining";
    }
    if ($xC == 21 && $yC == 14) {
        $check = "dining";
    }//dining 


    if ($xC == 2 && $yC == 23) {//"conservatory"
        $check = "conservatory";
    }
    if ($xC == 3 && $yC == 23) {
        $check = "conservatory";
    }
    if ($xC == 4 && $yC == 23) {
        $check = "conservatory";
    }
    if ($xC == 2 && $yC == 24) {
        $check = "conservatory";
    }
    if ($xC == 3 && $yC == 24) {
        $check = "conservatory";
    }
    if ($xC == 4 && $yC == 24) {
        $check = "conservatory";
    }//conservatory


    if ($xC == 10 && $yC == 19) {//"ballroom"
        $check = "ballroom";
    }
    if ($xC == 11 && $yC == 19) {
        $check = "ballroom";
    }
    if ($xC == 12 && $yC == 19) {
        $check = "ballroom";
    }
    if ($xC == 10 && $yC == 21) {
        $check = "ballroom";
    }
    if ($xC == 11 && $yC == 21) {
        $check = "ballroom";
    }
    if ($xC == 12 && $yC == 21) {
        $check = "ballroom";
    }//ballroom


    if ($xC == 20 && $yC == 20) {//"kitchen"
        $check = "kitchen";
    }
    if ($xC == 21 && $yC == 20) {
        $check = "kitchen";
    }
    if ($xC == 22 && $yC == 20) {
        $check = "kitchen";
    }
    if ($xC == 20 && $yC == 22) {
        $check = "kitchen";
    }
    if ($xC == 21 && $yC == 22) {
        $check = "kitchen";
    }
    if ($xC == 22 && $yC == 22) {
        $check = "kitchen";
    }//kitchen
    return $check;
}

function moveRoom($room, $counter) {
    $xCoord = 0;
    $yCoord = 0;
    if ($room == "study") {
        if ($counter == 0) {
            $xCoord = 2;
            $yCoord = 2;
        }
        if ($counter == 1) {
            $xCoord = 3;
            $yCoord = 2;
        }
        if ($counter == 2) {
            $xCoord = 4;
            $yCoord = 2;
        }
        if ($counter == 3) {
            $xCoord = 2;
            $yCoord = 4;
        }
        if ($counter == 4) {
            $xCoord = 3;
            $yCoord = 4;
        }
        if ($counter == 5) {
            $xCoord = 4;
            $yCoord = 4;
        }
    }//end of study
    if ($room == "hall") {
        if ($counter == 0) {
            $xCoord = 11;
            $yCoord = 3;
        }
        if ($counter == 1) {
            $xCoord = 12;
            $yCoord = 3;
        }
        if ($counter == 2) {
            $xCoord = 13;
            $yCoord = 3;
        }
        if ($counter == 3) {
            $xCoord = 11;
            $yCoord = 5;
        }
        if ($counter == 4) {
            $xCoord = 12;
            $yCoord = 5;
        }
        if ($counter == 5) {
            $xCoord = 13;
            $yCoord = 5;
        }//end of hall 
    }
    if ($room == "lounge") {
        if ($counter == 0) {
            $xCoord = 19;
            $yCoord = 2;
        }
        if ($counter == 1) {
            $xCoord = 20;
            $yCoord = 2;
        }
        if ($counter == 2) {
            $xCoord = 21;
            $yCoord = 2;
        }
        if ($counter == 3) {
            $xCoord = 19;
            $yCoord = 4;
        }
        if ($counter == 4) {
            $xCoord = 20;
            $yCoord = 4;
        }
        if ($counter == 5) {
            $xCoord = 21;
            $yCoord = 4;
        }
    }//end of lounge
    if ($room == "library") {
        if ($counter == 0) {
            $xCoord = 3;
            $yCoord = 8;
        }
        if ($counter == 1) {
            $xCoord = 4;
            $yCoord = 8;
        }
        if ($counter == 2) {
            $xCoord = 5;
            $yCoord = 8;
        }
        if ($counter == 3) {
            $xCoord = 3;
            $yCoord = 10;
        }
        if ($counter == 4) {
            $xCoord = 4;
            $yCoord = 10;
        }
        if ($counter == 5) {
            $xCoord = 5;
            $yCoord = 10;
        }
    }//end of library
    if ($room == "billiard") {
        if ($counter == 0) {
            $xCoord = 2;
            $yCoord = 14;
        }
        if ($counter == 1) {
            $xCoord = 3;
            $yCoord = 14;
        }
        if ($counter == 2) {
            $xCoord = 4;
            $yCoord = 14;
        }
        if ($counter == 3) {
            $xCoord = 2;
            $yCoord = 16;
        }
        if ($counter == 4) {
            $xCoord = 3;
            $yCoord = 16;
        }
        if ($counter == 5) {
            $xCoord = 4;
            $yCoord = 16;
        }
    }//end of billiard
    if ($room == "dining") {
        if ($counter == 0) {
            $xCoord = 19;
            $yCoord = 12;
        }
        if ($counter == 1) {
            $xCoord = 20;
            $yCoord = 12;
        }
        if ($counter == 2) {
            $xCoord = 21;
            $yCoord = 12;
        }
        if ($counter == 3) {
            $xCoord = 19;
            $yCoord = 14;
        }
        if ($counter == 4) {
            $xCoord = 20;
            $yCoord = 14;
        }
        if ($counter == 5) {
            $xCoord = 21;
            $yCoord = 14;
        }
    }//end of dining
    if ($room == "conservatory") {
        if ($counter == 0) {
            $xCoord = 2;
            $yCoord = 23;
        }
        if ($counter == 1) {
            $xCoord = 3;
            $yCoord = 23;
        }
        if ($counter == 2) {
            $xCoord = 4;
            $yCoord = 23;
        }
        if ($counter == 3) {
            $xCoord = 2;
            $yCoord = 24;
        }
        if ($counter == 4) {
            $xCoord = 3;
            $yCoord = 24;
        }
        if ($counter == 5) {
            $xCoord = 4;
            $yCoord = 24;
        }
    }//end of conservatory
    if ($room == "ballroom") {
        if ($counter == 0) {
            $xCoord = 10;
            $yCoord = 19;
        }
        if ($counter == 1) {
            $xCoord = 11;
            $yCoord = 19;
        }
        if ($counter == 2) {
            $xCoord = 12;
            $yCoord = 19;
        }
        if ($counter == 3) {
            $xCoord = 10;
            $yCoord = 21;
        }
        if ($counter == 4) {
            $xCoord = 11;
            $yCoord = 21;
        }
        if ($counter == 5) {
            $xCoord = 12;
            $yCoord = 21;
        }
    }//end of ballroom
    if ($room == "kitchen") {
        if ($counter == 0) {
            $xCoord = 20;
            $yCoord = 20;
        }
        if ($counter == 1) {
            $xCoord = 21;
            $yCoord = 20;
        }
        if ($counter == 2) {
            $xCoord = 22;
            $yCoord = 20;
        }
        if ($counter == 3) {
            $xCoord = 20;
            $yCoord = 22;
        }
        if ($counter == 4) {
            $xCoord = 21;
            $yCoord = 22;
        }
        if ($counter == 5) {
            $xCoord = 21;
            $yCoord = 22;
        }
    }//end of kitchen

    $results = array();
    $db = getDatabase();
    $stmt = $db->prepare("update characters set xCoord = :xCoord, YCoord = :yCoord where playerid = :playerid and gameKey = :gameKey");
    $binds = array(
        ":xCoord" => $xCoord,
        ":yCoord" => $yCoord,
        ":playerid" => $_SESSION['PlayerID'],
        ":gameKey" => $_SESSION['gameKey'],
    );
    if ($stmt->execute($binds) > 0) {
        unset($_SESSION['updateX']);
        unset($_SESSION['updateY']);
        $_SESSION['mode'] = "suggest";
    }
}

/* this was dumb
      function modeCheck(){
      if($_SESSION['movementMode'] == false && $_SESSION['suggestionMode'] == false && $_SESSION['accusationMode'] == false && $_SESSION['deadMode'] == false){
      $_SESSION['movementMode'] = true;
      $_SESSION['preMove'] = true;
      }
      else if($_SESSION['preMove'] == true){
      $_SESSION['premMove'] = false;
      $_SESSION['postMove'] = true;
      }
      else if($_SESSION['postMove'] == true){
      $_SESSION['postMove'] = false;
      $_SESSION['movementMode'] = false;
      $_SESSION['suggestionMode'] = true;
      $_SESSION['preSuggest'] = true;
      }
      else if($_SESSION['preSuggest'] == true){
      $_SESSION['preSuggest'] = false;
      $_SESSION['postSuggest'] = true;
      }
      else if($_SESSION['postSuggest'] == true){
      $_SESSION['postSuggest'] = false;
      $_SESSION['suggestionMode'] = false;
      $_SESSION['preAccusation'] = true;
      $_SESSION['accusationMode'] = true;
      }
      else if($_SESSION['preAccusation'] == true){
      $_SESSION['preAccusation'] = false;
      $_SESSION['postAccusation'] = true;
      }
      else if($_SESSION['postAccusation'] == true){
      $_SESSION['postAccusation'] = false;
      $_SESSION['accusationMode'] = false;
      $_SESSION['waitingMode'] = true;
      } */








    