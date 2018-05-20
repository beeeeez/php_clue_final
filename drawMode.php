<?php

function waitDraw() {
    $db = getDatabase();
    $stmt = $db->prepare("SELECT TurnID, NumberOfPlayers, CharacterID, CharacterColor FROM turn INNER JOIN game on turn.gameKey = game.gameKey INNER JOIN characters on turn.gameKey = characters.gameKey where turn.TurnID = characters.playerid AND characters.gameKey = :gameKey");
    $binds = array(
        ":gameKey" => $_SESSION['gameKey'],
    );
    if ($stmt->execute($binds) > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $x) {
            echo $x['CharacterColor'];
            echo "<script>";
            echo "let drawMe = document.getElementById('modeDraw');";
            echo 'drawMe.innerHTML = "';
            echo '<h3> It is ';
            echo $x['CharacterColor'];
            echo "'s Turn!";
            echo '"';
            echo "</script>";
        }
    } else {
        echo "it's shit!";
    }
}

function moveDraw() {

    if (!isset($_POST['updateX']) && !isset($_POST['updateY']) && isset($_POST['dice1']) && isset($_POST['dice2'])) {
        echo "fuck9";
        whereamI();
        $xC = $_SESSION['xCoord'];
        $yC = $_SESSION['yCoord'];
        unset($_SESSION['xCoord']);
        unset($_SESSION['yCoord']);
        $room = roomCheck($xC, $yC);

        if ($room != "none") {
            echo '<img src="./dice/';
            echo $_POST['dice1'];
            echo '.png"><img src="./dice/';
            echo $_POST['dice2'];
            echo '.png"><br/>Click on the board where you would like to move!<br />Move one space at a slime!';
            echo $room;
            $_SESSION['comingOut'] = true;
            validMoveRoom($room);
        } else {
            echo '<img src="./dice/';
            echo $_POST['dice1'];
            echo '.png"><img src="./dice/';
            echo $_POST['dice2'];
            echo '.png"><br/>Click on the board where you would like to move!<br />Move one space at a time!';
            validMove($room);
        }
    } else {

        if (!isset($_POST['dice1']) && !isset($_POST['dice2'])) {
            $dice1 = rand(1, 6);
            $dice2 = rand(1, 6);
            echo '<img src="./dice/0.png"><img src="./dice/0.png"><br/>';
            echo '<form action="#" method="POST"><input type="submit" value="Roll The Dice!" /><input type="hidden" name="dice1" value="';
            echo $dice1;
            echo '"><input type="hidden" name="dice2" value="';
            echo $dice2;
            echo '"></form>';
        } else {
            echo '<img src="./dice/';
            echo $_POST['dice1'];
            echo '.png"><img src="./dice/';
            echo $_POST['dice2'];
            echo '.png"><br/>Click on the board where you would like to move!<br />Move one space at a chime!';
            validMove();
        }
    }
}

function getRoomID($room) {
    if ($room == "ballroom") {
        $roomID = 13;
    } else if ($room == "kitchen") {
        $roomID = 14;
    } else if ($room == "conservatory") {
        $roomID = 15;
    } else if ($room == "library") {
        $roomID = 16;
    } else if ($room == "billiard") {
        $roomID = 17;
    } else if ($room == "study") {
        $roomID = 18;
    } else if ($room == "hall") {
        $roomID = 19;
    } else if ($room == "lounge") {
        $roomID = 20;
    } else if ($room == "dining") {
        $roomID = 21;
    } else {
        $roomID = 0;
    }
    return $roomID;
}

function drawSuggest() {
    
    echo 'start suggest draw';
    if (isset($_POST['person']) && isset($_POST['weapon']) && isset($_POST['location'])) {
        echo 'start post draw';
        echo $_POST['person'];
        echo "<br />";
        echo $_POST['weapon'];
        echo "<br />";
        echo $_POST['location'];
        echo "<br />";
        $startLoop = "false";
        $key = 0;
        $keyBreak = 0;
        while ($key + 1 <= $_SESSION['numberofPlayers'] && $keyBreak < 6) {
            $reset =false;
            echo "loop";
            echo $keyBreak;
            echo "<br />";
            echo $_SESSION['playerList'][$key];
            echo "<br />";
            echo $_SESSION['playerList'][$key]."==".$_SESSION['PlayerID'];
            echo "-".$startLoop;
            echo "<br />";
            if ((string)$_SESSION['playerList'][$key] == (string)$_SESSION['PlayerID']){
                echo "Same value!";
                echo "-".$startLoop;
            }
            if (((string)$_SESSION['playerList'][$key] == (string)$_SESSION['PlayerID']) && $startLoop == "false") {
                $startLoop = "true";
                echo "found myself";
            }
           
             
                
            else if ($startLoop == "true") {
                if ($_SESSION['playerList'][$key] == $_SESSION['PlayerID']) {
                    $startLoop = "false";
                    $key = 100;
                    $keyBreak =6;
                    echo $key;
                echo "<br />";
                    echo "immediately making match";
                    $_SESSION['mode'] = "accuse";
                    echo '<form action="#" method="POST" id="showCards"><input type="hidden" value="';
                    echo 0;
                    echo '" name="showCardId"/> <input type="hidden" value="';
                    echo 0;
                    echo '" name ="showCharacter" /></form>';/*
                    echo "<script>";
                    echo 'let whoShowed = document.getElementById("showCards");';
                    echo 'whoShowed.submit();';
                    echo '</script>';*/
                } else {
                    echo "<br />beginning sql statement";
                    $results = array();
                    try{
                    $db = getDatabase();
                    echo "<br /> mehhhh";
                    $stmt = "nbhh";
                    $checkPerson = $_POST['person'];
                    $checkWeapon = $_POST['weapon'];
                    $checkLoc = $_POST['location'];
                    $checkPlayer = $_SESSION['playerList'][$key];
                    $checkGame = $_SESSION['gameKey'];
                    //echo "<br />SELECT ph.CardId, c.CharacterColor FROM playerhand ph INNER JOIN characters c on ph.PlayerId = c.PlayerID WHERE ph.PlayerId = $checkPlayer AND ph.GameKey = '$checkGame' AND ph.CardId in ($checkPerson, $checkWeapon, $checkLoc) LIMIT 1";
                    //$stmt = $db->prepare("SELECT ph.CardId, c.CharacterColor FROM playerhand ph INNER JOIN characters c on ph.PlayerId = c.PlayerID WHERE ph.PlayerId = $checkPlayer AND ph.GameKey = $checkGame AND ph.CardId in ($checkPerson, $checkWeapon, $checkLoc) LIMIT 1");
                    $stmt = $db->prepare("SELECT CardId FROM playerhand  WHERE PlayerId = $checkPlayer AND GameKey = $checkGame AND CardId in ($checkPerson, $checkWeapon, $checkLoc) LIMIT 1");
                    
                    echo "<br /> mehhhh";
                    echo "<br />";
                    echo $stmt;
                    echo '<br /><form action="#" method="POST" id="showCards">';
                    /*$binds = array(
                        //":playerid" => $_SESSION['playerList'][$key],
                        ":gameKey" => $_SESSION['gameKey'],                        
                        ":person" => $_POST['person'],
                        ":weapon" => $_POST['weapon'],
                        ":location" => $_POST['location'],
                    );*/
                    if ($stmt->execute()) {
                        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            echo "butts";
                            echo '<input type="hidden" value="';
                            echo $results['CardId'];
                            echo '" name="showCardId"/> <input type="hidden" value="';
                            echo $results['CharacterColor'];
                            echo '" name ="showCharacter" /></form>';
                            echo $results['CardId'];
                            echo $results['CharacterColor'];

                        
                        echo "</form>executed sql";
                        $_SESSION['mode'] = "accuse";
                        $key = 100;
                        $keyBreak = 6;/*
                        echo "<script>";
                        echo 'let whoShowed = document.getElementById("showCards");';
                        echo 'whoShowed.submit();';
                        echo '</script>';*/
                    
                    }
                    }
                    catch(PDOException $e){
                        echo $e->getMessage();
                    }
                }
            }
            if ($key + 1 == $_SESSION['numberofPlayers']) {
                $key = 0;
                $reset =true;
                echo "reset key";
                echo $key;
                echo "<br />";
            }
            echo "increment key";
            if(!$reset){
            $key++;
            }
            echo $key;
                echo "<br />";
            $keyBreak++;
        }
    }
    else {
  whereamI();
  $room = roomcheck($_SESSION['xCoord'], $_SESSION['yCoord']);
  if ($room == "none") {
  $_SESSION['mode'] = "accuse";
  echo "<script>location.reload();</script>";
  } else {
  $roomID = getRoomID($room);
  echo '<form action="#" method="POST">Select a Person : <select name="person"><option value="1">Miss Scarlet</option><option value="2">Professor Plum</option><option value="3">Mrs. Peacock</option><option value="4">Mr. Green</option><option value="5">Colonel Mustard</option><option value="6">Mrs. White</option></select>';
  echo '<br />';
  echo 'Select a Weapon : <select name ="weapon"><option value="7">Candlestick</option><option value="8">Knife</option><option value="9">Lead Pipe</option><option value="10">Revolver</option><option value="11">Rope</option><option value="12">Wrench</option></select>';
  echo '<br />';
  echo "You are in : ";
  echo '<input type="hidden" value="';
  echo $roomID;
  echo '" name="location" />';
  echo $room;
  echo '<br /><input type="submit" value="Make a Suggestion" /></form>';
  }
}
}

/*

  foreach ($_SESSION['playerList'] as $key => $value) {
  echo 'loop';
  echo $key;
  echo "<br />";
  if ($value == $_SESSION['PlayerID']) {
  $startLoop = true;
  echo 'start loop';
  $counter = $key + 1;
  if ($counter == $_SESSION['numberofPlayers']) {
  $key = 0;
  echo 'loop reset';

  }
  } else if ($startLoop == true) {
  if ($counter == $_SESSION['numberofPlayers']) {
  $key = 0;
  echo 'loop reset';
  } else if ($value == $_SESSION['PlayerID']) {
  $startLoop = false;
  $_SESSION['mode'] = "accuse";
  echo '<form action="#" method="POST" id="showCards"><input type="hidden" value="';
  echo 0;
  echo '" name="showCardId"/> <input type="hidden" value="';
  echo 0;
  echo '" name ="showCharacter" /></form>';
  $endLoop = true;
  echo "<script>";
  echo 'let whoShowed = document.getElementById("showCards");';
  echo 'whoShowed.submit();';
  echo '</script>';
  }
  else {
  echo "<br />beginning sql statement";
  $results = array();
  $db = getDatabase();
  $stmt = $db->prepare("SELECT ph.CardId, c.CharacterColor FROM playerhand ph INNER JOIN characters c on ph.PlayerId = c.PlayerID WHERE ph.PlayerId = :playerid AND ph.GameKey = :gameKey AND ph.CardId in (:person, :weapon, :location) LIMIT 1");
  echo "<br />";
  echo $stmt;
  echo "<br />";
  $binds = array(
  ":gameKey" => $_SESSION['gameKey'],
  ":playerid" => $value,
  ":person" => $_POST['person'],
  ":weapon" => $_POST['weapon'],
  ":location" => $_POST['location'],
  );
  if ($stmt->execute($binds) > 0) {
  $results = $stmt->fetch(PDO::FETCH_ASSOC);
  foreach ($results as $x) {
  echo '<form action="#" method="POST" id="showCards"><input type="hidden" value="';
  echo $x['CardId'];
  echo '" name="showCardId"/> <input type="hidden" value="';
  echo $x['CharacterColor'];
  echo '" name ="showCharacter" /></form>';
  echo $x['CardId'];
  echo $x['CharacterColor'];


  }
  $_SESSION['mode'] = "accuse";
  $endLoop = true;
  echo "<script>";
  echo 'let whoShowed = document.getElementById("showCards");';
  echo 'whoShowed.submit();';
  echo '</script>';
  }
  }}
  }
  } else {
  whereamI();
  $room = roomcheck($_SESSION['xCoord'], $_SESSION['yCoord']);
  if ($room == "none") {
  $_SESSION['mode'] = "accuse";
  echo "<script>location.reload();</script>";
  } else {
  $roomID = getRoomID($room);
  echo '<form action="#" method="POST">Select a Person : <select name="person"><option value="1">Miss Scarlet</option><option value="2">Professor Plum</option><option value="3">Mrs. Peacock</option><option value="4">Mr. Green</option><option value="5">Colonel Mustard</option><option value="6">Mrs. White</option></select>';
  echo '<br />';
  echo 'Select a Weapon : <select name ="weapon"><option value="7">Candlestick</option><option value="8">Knife</option><option value="9">Lead Pipe</option><option value="10">Revolver</option><option value="11">Rope</option><option value="12">Wrench</option></select>';
  echo '<br />';
  echo "You are in : ";
  echo '<input type="hidden" value="';
  echo $roomID;
  echo '" name="location" />';
  echo $room;
  echo '<br /><input type="submit" value="Make a Suggestion" /></form>';
  }
  } */

function drawHand() {
    $db = getDatabase();
    $stmt = $db->prepare("Select * from playerhand where gameKey = :gameKey and playerid = :playerid");
    $binds = array(
        ":gameKey" => $_SESSION['gameKey'],
        ":playerid" => $_SESSION['PlayerID']
    );

    if ($stmt->execute($binds) > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $x) {
            echo '<img src="';
            echo "./images/";
            echo $x['CardId'];
            echo '.png" />';
        }
    }
}

function accuseDraw() {
    if (isset($_POST['meh'])) {
        changeTurnId();
        echo "<script>location.reload();</script>";
    } else {
        echo '<form action="#" method="POST" id="showCards"><input type="hidden" value="meh" name="meh"><input type="submit" value="meh"></form>';
    }
}

function doorwayCheck() {
    $room = "none";
    if ($_POST['updateX'] == 7 && $_POST['updateY'] == 5) {
        $room = "study";
    } else if ($_POST['updateX'] == 9 && $_POST['updateY'] == 5) {
        $room = "hall";
    } else if ($_POST['updateX'] == 12 && $_POST['updateY'] == 8) {
        $room = "hall";
    } else if ($_POST['updateX'] == 13 && $_POST['updateY'] == 8) {
        $room = "hall";
    } else if ($_POST['updateX'] == 18 && $_POST['updateY'] == 7) {
        $room = "lounge";
    } else if ($_POST['updateX'] == 8 && $_POST['updateY'] == 9) {
        $room = "library";
    } else if ($_POST['updateX'] == 4 && $_POST['updateY'] == 12) {
        $room = "library";
    } else if ($_POST['updateX'] == 2 && $_POST['updateY'] == 12) {
        $room = "billiard";
    } else if ($_POST['updateX'] == 7 && $_POST['updateY'] == 16) {
        $room = "billiard";
    } else if ($_POST['updateX'] == 18 && $_POST['updateY'] == 9) {
        $room = "dining";
    } else if ($_POST['updateX'] == 16 && $_POST['updateY'] == 13) {
        $room = "dining";
    } else if ($_POST['updateX'] == 20 && $_POST['updateY'] == 18) {
        $room = "kitchen";
    } else if ($_POST['updateX'] == 6 && $_POST['updateY'] == 20) {
        $room = "conservatory";
    } else if ($_POST['updateX'] == 8 && $_POST['updateY'] == 20) {
        $room = "ballroom";
    } else if ($_POST['updateX'] == 10 && $_POST['updateY'] == 17) {
        $room = "ballroom";
    } else if ($_POST['updateX'] == 15 && $_POST['updateY'] == 17) {
        $room = "ballroom";
    } else if ($_POST['updateX'] == 17 && $_POST['updateY'] == 20) {
        $room = "ballroom";
    }
    return $room;
}

function checkValid($xC, $yC) {
    $check = true;

    if ($xC < 1 || $yC < 1) {
        $check = false;
    }
    for ($x = 1; $x <= 7; $x++) {//study
        for ($y = 1; $y <= 4; $y++) {
            if ($x == $xC && $y == $yC) {
                $check = false;
            }
        }
    }
    for ($x = 10; $x <= 15; $x++) {//hall
        for ($y = 1; $y <= 7; $y++) {
            if ($x == $xC && $y == $yC) {
                $check = false;
            }
        }
    }

    for ($x = 18; $x <= 25; $x++) {//lounge
        for ($y = 1; $y <= 6; $y++) {
            if ($x == $xC && $y == $yC) {
                $check = false;
            }
        }
    }

    for ($x = 1; $x <= 6; $x++) {//library
        for ($y = 7; $y <= 11; $y++) {
            if ($x == $xC && $y == $yC) {
                $check = false;
            }
        }
    }
    if (7 == $xC && 8 == $yC) {
        $check = false;
    }
    if (7 == $xC && 9 == $yC) {
        $check = false;
    }
    if (7 == $xC && 10 == $yC) {
        $check = false;
    }

    for ($x = 10; $x <= 14; $x++) {//centercluething
        for ($y = 9; $y <= 15; $y++) {
            if ($x == $xC && $y == $yC) {
                $check = false;
            }
        }
    }

    for ($x = 17; $x <= 25; $x++) {//dining room
        for ($y = 10; $y <= 15; $y++) {
            if ($x == $xC && $y == $yC) {
                $check = false;
            }
        }
    }
    if (20 == $xC && 16 == $yC) {
        $check = false;
    }
    if (21 == $xC && 16 == $yC) {
        $check = false;
    }
    if (22 == $xC && 16 == $yC) {
        $check = false;
    }
    if (23 == $xC && 16 == $yC) {
        $check = false;
    }
    if (24 == $xC && 16 == $yC) {
        $check = false;
    }

    for ($x = 1; $x <= 6; $x++) {//billiard room
        for ($y = 13; $y <= 17; $y++) {
            if ($x == $xC && $y == $yC) {
                $check = false;
            }
        }
    }
    for ($x = 1; $x <= 5; $x++) {//conservatory 
        for ($y = 20; $y <= 25; $y++) {
            if ($x == $xC && $y == $yC) {
                $check = false;
            }
        }
    }
    if (6 == $xC && 21 == $yC) {
        $check = false;
    }
    if (6 == $xC && 22 == $yC) {
        $check = false;
    }
    if (6 == $xC && 23 == $yC) {
        $check = false;
    }
    if (6 == $xC && 24 == $yC) {
        $check = false;
    }

    for ($x = 19; $x <= 24; $x++) {//kitchen 
        for ($y = 19; $y <= 24; $y++) {
            if ($x == $xC && $y == $yC) {
                $check = false;
            }
        }
    }
    for ($x = 9; $x <= 16; $x++) {//ballroom 
        for ($y = 18; $y <= 23; $y++) {
            if ($x == $xC && $y == $yC) {
                $check = false;
            }
        }
    }
    for ($x = 11; $x <= 14; $x++) {//ballroom 
        for ($y = 23; $y <= 25; $y++) {
            if ($x == $xC && $y == $yC) {
                $check = false;
            }
        }
    }
    if (7 == $xC && 1 == $yC) {
        $check = false;
    }
    if (9 == $xC && 1 == $yC) {
        $check = false;
    }
    if (16 == $xC && 1 == $yC) {
        $check = false;
    }
    if (18 == $xC && 1 == $yC) {
        $check = false;
    }
    if (1 == $xC && 5 == $yC) {
        $check = false;
    }
    if (1 == $xC && 7 == $yC) {
        $check = false;
    }
    if (24 == $xC && 7 == $yC) {
        $check = false;
    }
    if (24 == $xC && 9 == $yC) {
        $check = false;
    }
    if (1 == $xC && 11 == $yC) {
        $check = false;
    }
    if (1 == $xC && 12 == $yC) {
        $check = false;
    }
    if (1 == $xC && 18 == $yC) {
        $check = false;
    }
    if (1 == $xC && 20 == $yC) {
        $check = false;
    }
    if (24 == $xC && 17 == $yC) {
        $check = false;
    }
    if (24 == $xC && 19 == $yC) {
        $check = false;
    }


    for ($x = 1; $x < 10; $x++) {
        if ($x == $xC && $y == $yC) {
            $check = false;
        }
    }
    for ($x = 16; $x < 25; $x++) {
        if ($x == $xC && $y == $yC) {
            $check = false;
        }
    }







    return $check;
}

function validMove() {
    echo "fuck11";
    $theGoods = array();
    $db = getDatabase();
    $stmt = $db->prepare("SELECT * FROM characters where gameKey = :gameKey AND PlayerID = :playerID");
    $binds = array(
        ":gameKey" => $_SESSION["gameKey"],
        ":playerID" => $_SESSION["PlayerID"]
    );
    if ($stmt->execute($binds) > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $total = $_POST['dice1'] + $_POST['dice2'];
        foreach ($results as $x) {

            $xCoord = $x['xCoord'];
            $yCoord = $x['YCoord'];
        }
        echo "fuck12";
        $room = roomCheck($xCoord, $yCoord);
        $check = roomSlotCheck($xCoord, $yCoord, $room);

        echo "<br>ycoord:";
        echo $yCoord;
        echo "<br>xcoord:";
        echo $xCoord;

        $up = $yCoord - 1;
        $down = $yCoord + 1;
        $left = $xCoord - 1;
        $right = $xCoord + 1;
        $check = false;


        $check = checkValid($xCoord, $up);
        echo $check;

        if ($check == true) {
            echo "<style>";
            echo "#x$xCoord-y$up{background-color:green;}";
            echo "</style>";
            echo '<form action="#" method="POST" id="updateU">';
            echo '<input type="hidden" value="';
            echo "$xCoord";
            echo '" name="updateX">';
            echo '<input type="hidden" value="';
            echo $_POST['dice1'];
            echo '" name="dice1">';
            echo '<input type="hidden" value="';
            echo $_POST['dice2'];
            echo '" name="dice2">';
            echo '<input type="hidden" value="';
            echo "$up";
            echo '" name="updateY">';
            echo '</form>';
            echo "<script>";
            echo 'let clickEventU = document.getElementById("x';
            echo "$xCoord-y$up";
            echo '");';
            echo 'let formU = document.getElementById("updateU");';
            echo 'clickEventU.onclick = function() {';
            echo 'formU.submit();';
            echo '};';



            /*
              echo "<style>";
              echo "#x$xCoord-y$up{background-color:green;}";
              echo "</style>";
              echo "<script>";
              echo ' $(document).ready (function() {
              $("';
              echo "#x$xCoord-y$up";
              echo '").click (function (e) {';
              echo "let updateX = ";
              echo $xCoord;
              echo "; let updateY =";
              echo $up;
              echo "; let dice1 = ";
              echo $_POST['dice1'];
              echo "; let dice2 = ";
              echo $_POST['dice2'];
              echo '; $.post( "gameBoard.php", { updateX: updateX, updateY: updateY, dice1: dice1, dice2: dice2 }); });';
             */
            echo "</script>";
        }
    }

    $check = checkValid($xCoord, $down);
    if ($check == true) {

        echo "<style>";
        echo "#x$xCoord-y$down{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateD">';
        echo '<input type="hidden" value="';
        echo "$xCoord";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "$down";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventD = document.getElementById("x';
        echo "$xCoord-y$down";
        echo '");';
        echo 'let formD = document.getElementById("updateD");';
        echo 'clickEventD.onclick = function() {';
        echo 'formD.submit();';
        echo '};';
        /*
          echo "<style>";
          echo "#x$xCoord-y$down{background-color:green;}";
          echo "</style>";
          echo "<script>";
          echo "<script>";
          echo ' $(document).ready (function() {
          $("';
          echo "#x$xCoord-y$down";
          echo '").click (function (e) {';
          echo "let updateX = ";
          echo $xCoord;
          echo "; let updateY =";
          echo $down;
          echo "; let dice1 = ";
          echo $_POST['dice1'];
          echo "; let dice2 = ";
          echo $_POST['dice2'];
          echo '; $.post( "gameBoard.php", { updateX: updateX, updateY: updateY, dice1: dice1, dice2: dice2 }); });';
         */


        echo "</script>";
    }



    $check = checkValid($left, $yCoord);
    if ($check == true) {
        echo "<style>";
        echo "#x$left-y$yCoord{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateL">';
        echo '<input type="hidden" value="';
        echo "$left";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "$yCoord";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventL = document.getElementById("x';
        echo "$left-y$yCoord";
        echo '");';
        echo 'let formL = document.getElementById("updateL");';
        echo 'clickEventL.onclick = function() {';
        echo 'formL.submit();';
        echo '};';
        /*
          echo "<style>";
          echo "#x$left-y$yCoord{background-color:green;}";
          echo "</style>";
          echo '<form action="#" method="POST" >';
          echo '<input type="hidden" value="';
          echo "$left";
          echo '" name="updateX">';
          echo '<input type="hidden" value="';
          echo "$yCoord";
          echo '" name="updateY">';
          echo '</form>';
          echo "<script>";
          echo ' $(document).ready (function() {
          $("';
          echo "#x$left-y$yCoord";
          echo '").click (function (e) {';
          echo 'form.submit()}); });';

          /*
          echo "let updateX = ";
          echo $left;
          echo "; let updateY =";
          echo $yCoord;
          echo "; let dice1 = ";
          echo $_POST['dice1'];
          echo "; let dice2 = ";
          echo $_POST['dice2'];
          echo '; $.post( "gameBoard.php", { updateX: updateX, updateY: updateY, dice1: dice1, dice2: dice2 }); });';
         */
        echo "</script>";
    }

    $check = checkValid($right, $yCoord);
    if ($check == true) {
        echo "<style>";
        echo "#x$right-y$yCoord{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateR">';
        echo '<input type="hidden" value="';
        echo "$right";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "$yCoord";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventR = document.getElementById("x';
        echo "$right-y$yCoord";
        echo '");';
        echo 'let formR = document.getElementById("updateR");';
        echo 'clickEventR.onclick = function() {';
        echo 'formR.submit();';
        echo '};';



        /*
          echo ' $(document).ready (function() {
          $("';
          echo "#x$right-y$yCoord";
          echo '").click (function (e) {';
          echo '$("update").submit()}); });';
         *//*
          echo "let updateX = ";
          echo $right;
          echo "; let updateY =";
          echo $yCoord;
          echo "; let dice1 = ";
          echo $_POST['dice1'];
          echo "; let dice2 = ";
          echo $_POST['dice2'];
          echo '; $.post( "gameBoard.php", { updateX: updateX, updateY: updateY, dice1: dice1, dice2: dice2 }); }); });';
         */


        echo "</script>";
    }
}

function validMoveRoom($room) {
    /*
      whereamI();
      $xC = $_SESSION["xCoord"];
      $yC = $_SESSION["yCoord"];
      unset($_SESSION["xCoord"]);
      unset($_SESSION["yCoord"]);
     */


    if ($room == "study") {
        echo "<style>";
        echo "#x7-y5{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateStudy1">';
        echo '<input type="hidden" value="';
        echo "7";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "5";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventStudy1 = document.getElementById("x';
        echo "7-y5";
        echo '");';
        echo 'let formStudy1 = document.getElementById("updateStudy1");';
        echo 'clickEventStudy1.onclick = function() {';
        echo 'formStudy1.submit();';
        echo '};';
        echo '</script>';

        //secret pass
        echo "<style>";
        echo "#x1-y4{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateStudyPass">';
        echo '<input type="hidden" value="';
        echo "20";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "18";
        echo '" name="updateY">';
        echo '<input type="hidden" value="true" name="secretPass">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventStudyPass = document.getElementById("x';
        echo "1-y4";
        echo '");';
        echo 'let formStudyPass = document.getElementById("updateStudyPass");';
        echo 'clickEventStudyPass.onclick = function() {';
        echo 'formStudyPass.submit();';
        echo '};';
        echo '</script>';
    }

    if ($room == "hall") {
        echo "<style>";
        echo "#x9-y5{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateHall1">';
        echo '<input type="hidden" value="';
        echo "9";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "5";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventHall1 = document.getElementById("x';
        echo "9-y5";
        echo '");';
        echo 'let formHall1 = document.getElementById("updateHall1");';
        echo 'clickEventHall1.onclick = function() {';
        echo 'formHall1.submit();';
        echo '};';
        echo '</script>';
        //door2
        echo "<style>";
        echo "#x12-y8{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateHall2">';
        echo '<input type="hidden" value="';
        echo "12";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "8";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventHall2 = document.getElementById("x';
        echo "12-y8";
        echo '");';
        echo 'let formHall2 = document.getElementById("updateHall2");';
        echo 'clickEventHall2.onclick = function() {';
        echo 'formHall2.submit();';
        echo '};';
        echo '</script>';

        //door 3
        echo "<style>";
        echo "#x13-y8{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateHall3">';
        echo '<input type="hidden" value="';
        echo "13";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "8";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventHall3 = document.getElementById("x';
        echo "13-y8";
        echo '");';
        echo 'let formHall3 = document.getElementById("updateHall3");';
        echo 'clickEventHall3.onclick = function() {';
        echo 'formHall3.submit();';
        echo '};';
        echo '</script>';
    } else if ($room == "library") {
        echo "<style>";
        echo "#x8-y9{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateLibrary1">';
        echo '<input type="hidden" value="';
        echo "8";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "9";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventLibrary1 = document.getElementById("x';
        echo "8-y9";
        echo '");';
        echo 'let formLibrary1 = document.getElementById("updateLibrary1");';
        echo 'clickEventLibrary1.onclick = function() {';
        echo 'formLibrary1.submit();';
        echo '};';
        echo "</script>";
        //door2
        echo "<style>";
        echo "#x4-y12{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateLibrary2">';
        echo '<input type="hidden" value="';
        echo "4";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "12";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventLibrary2 = document.getElementById("x';
        echo "4-y12";
        echo '");';
        echo 'let formLibrary2 = document.getElementById("updateLibrary2");';
        echo 'clickEventLibrary2.onclick = function() {';
        echo 'formLibrary2.submit();';
        echo '};';
        echo "</script>";
    } else if ($room == "lounge") {
        echo "<style>";
        echo "#x18-y7{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateLounge1">';
        echo '<input type="hidden" value="';
        echo "18";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "7";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventLounge1 = document.getElementById("x';
        echo "18-y7";
        echo '");';
        echo 'let formLounge1 = document.getElementById("updateLounge1");';
        echo 'clickEventLounge1.onclick = function() {';
        echo 'formLounge1.submit();';
        echo '};';
        echo "</script>";
        //secret pass
        echo "<style>";
        echo "#x24-y6{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateLoungePass">';
        echo '<input type="hidden" value="';
        echo "6";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "20";
        echo '" name="updateY">';
        echo '<input type="hidden" value="true" name="secretPass">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventLoungePass = document.getElementById("x';
        echo "24-y6";
        echo '");';
        echo 'let formLoungePass = document.getElementById("updateLoungePass");';
        echo 'clickEventLoungePass.onclick = function() {';
        echo 'formLoungePass.submit();';
        echo '};';
        echo '</script>';
    } else if ($room == "billiard") {
        echo "<style>";
        echo "#x2-y12{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateBilliard1">';
        echo '<input type="hidden" value="';
        echo "2";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "12";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventBilliard1 = document.getElementById("x';
        echo "2-y12";
        echo '");';
        echo 'let formBilliard1 = document.getElementById("updateBilliard1");';
        echo 'clickEventBilliard1.onclick = function() {';
        echo 'formBilliard1.submit();';
        echo '};';
        echo "</script>";
        //door2
        echo "<style>";
        echo "#x7-y16{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateBilliard2">';
        echo '<input type="hidden" value="';
        echo "7";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "16";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventBilliard2 = document.getElementById("x';
        echo "7-y16";
        echo '");';
        echo 'let formBilliard2 = document.getElementById("updateBilliard2");';
        echo 'clickEventBilliard2.onclick = function() {';
        echo 'formBilliard2.submit();';
        echo '};';
        echo "</script>";
    } else if ($room == "dining") {
        echo "<style>";
        echo "#x18-y9{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateDining1">';
        echo '<input type="hidden" value="';
        echo "18";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "9";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventDining1 = document.getElementById("x';
        echo "18-y9";
        echo '");';
        echo 'let formDining1 = document.getElementById("updateDining1");';
        echo 'clickEventDining1.onclick = function() {';
        echo 'formDining1.submit();';
        echo '};';
        echo "</script>";
        //door2
        echo "<style>";
        echo "#x16-y13{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateDining2">';
        echo '<input type="hidden" value="';
        echo "16";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "13";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventDining2 = document.getElementById("x';
        echo "16-y13";
        echo '");';
        echo 'let formDining2 = document.getElementById("updateDining2");';
        echo 'clickEventDining2.onclick = function() {';
        echo 'formDining2.submit();';
        echo '};';
        echo "</script>";
    } else if ($room == "kitchen") {
        echo "<style>";
        echo "#x20-y18{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateKitchen1">';
        echo '<input type="hidden" value="';
        echo "20";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "18";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventKitchen1 = document.getElementById("x';
        echo "20-y18";
        echo '");';
        echo 'let formKitchen1 = document.getElementById("updateKitchen1");';
        echo 'clickEventKitchen1.onclick = function() {';
        echo 'formKitchen1.submit();';
        echo '};';
        echo "</script>";

        //secret pass
        echo "<style>";
        echo "#x19-y24{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateKitchenPass">';
        echo '<input type="hidden" value="';
        echo "7";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "5";
        echo '" name="updateY">';
        echo '<input type="hidden" value="true" name="secretPass">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventKitchenPass = document.getElementById("x';
        echo "19-y24";
        echo '");';
        echo 'let formKitchenPass = document.getElementById("updateKitchenPass");';
        echo 'clickEventKitchenPass.onclick = function() {';
        echo 'formKitchenPass.submit();';
        echo '};';
        echo '</script>';
    } else if ($room == "conservatory") {
        echo "<style>";
        echo "#x6-y20{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateConservatory1">';
        echo '<input type="hidden" value="';
        echo "6";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "20";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventConservatory1 = document.getElementById("x';
        echo "6-y20";
        echo '");';
        echo 'let formConservatory1 = document.getElementById("updateConservatory1");';
        echo 'clickEventConservatory1.onclick = function() {';
        echo 'formConservatory1.submit();';
        echo '};';
        echo "</script>";

        //secret pass
        echo "<style>";
        echo "#x2-y20{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateConservatoryPass">';
        echo '<input type="hidden" value="';
        echo "18";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "7";
        echo '" name="updateY">';
        echo '<input type="hidden" value="true" name="secretPass">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventConservatoryPass = document.getElementById("x';
        echo "2-y20";
        echo '");';
        echo 'let formConservatoryPass = document.getElementById("updateConservatoryPass");';
        echo 'clickEventConservatoryPass.onclick = function() {';
        echo 'formConservatoryPass.submit();';
        echo '};';
        echo '</script>';
    }


    if ($room == "ballroom") {
        echo "<style>";
        echo "#x8-y20{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateBallroom1">';
        echo '<input type="hidden" value="';
        echo "8";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "20";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventBallroom1 = document.getElementById("x';
        echo "8-y20";
        echo '");';
        echo 'let formBallroom1 = document.getElementById("updateBallroom1");';
        echo 'clickEventBallroom1.onclick = function() {';
        echo 'formBallroom1.submit();';
        echo '};';
        echo '</script>';
        //door2
        echo "<style>";
        echo "#x10-y17{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateBallroom2">';
        echo '<input type="hidden" value="';
        echo "10";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "17";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventBallroom2 = document.getElementById("x';
        echo "10-y17";
        echo '");';
        echo 'let formBallroom2 = document.getElementById("updateBallroom2");';
        echo 'clickEventBallroom2.onclick = function() {';
        echo 'formBallroom2.submit();';
        echo '};';
        echo '</script>';
        //door 3
        echo "<style>";
        echo "#x15-y17{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateBallroom3">';
        echo '<input type="hidden" value="';
        echo "15";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "17";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventBallroom3 = document.getElementById("x';
        echo "15-y17";
        echo '");';
        echo 'let formBallroom3 = document.getElementById("updateBallroom3");';
        echo 'clickEventBallroom3.onclick = function() {';
        echo 'formBallroom3.submit();';
        echo '};';
        echo '</script>';
        //door 4
        echo "<style>";
        echo "#x17-y20{background-color:green;}";
        echo "</style>";
        echo '<form action="#" method="POST" id="updateBallroom4">';
        echo '<input type="hidden" value="';
        echo "17";
        echo '" name="updateX">';
        echo '<input type="hidden" value="';
        echo $_POST['dice1'];
        echo '" name="dice1">';
        echo '<input type="hidden" value="';
        echo $_POST['dice2'];
        echo '" name="dice2">';
        echo '<input type="hidden" value="';
        echo "20";
        echo '" name="updateY">';
        echo '</form>';
        echo "<script>";
        echo 'let clickEventBallroom4 = document.getElementById("x';
        echo "17-y20";
        echo '");';
        echo 'let formBallroom4 = document.getElementById("updateBallroom4");';
        echo 'clickEventBallroom4.onclick = function() {';
        echo 'formBallroom4.submit();';
        echo '};';
        echo '</script>';
    }
}

?> 