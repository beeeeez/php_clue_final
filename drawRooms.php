<?php

/*
  function drawRooms(){

  for($x = 1; $x<= 8; $x++){
  for($y = 1; $y <=4; $y++){
  $coords = "x$x-y$y";
  echo "<style>";
  echo "#$coords";
  echo "{background: url(./clue_assets/study/$coords.jpg)}";
  echo "</style>";

  }
  }

  for($x = 11; $x<=17 ; $x++){
  for($y = 1; $y <=7; $y++){
  $coords = "x$x-y$y";
  echo "<style>";
  echo "#$coords";
  echo "{background: url(./clue_assets/study/$coords.jpg)}";
  echo "</style>";

  }
  }

  } */
/*
  function drawBlack(){
  echo "<style>";
  echo "#x8-y1 ";
  echo "{background-color:white;border-color:transparent;}";
  echo "</style>";

  }
 */

function drawGrid() {
    for ($x = 1; $x <= 24; $x++) {
        echo '<div class="row">';
        for ($y = 1; $y <= 25; $y++) {
            echo '<div class="grid" id="x';
            echo $x;
            echo "-y";
            echo $y;
            echo '">';
            //echo "$x-$y";
            echo '</div>';
        }
        echo ' </div>';
    }
}

function drawRooms() {
    echo '<style>';
    for ($x = 1; $x <= 7; $x++) {//study
        for ($y = 1; $y <= 4; $y++) {
            echo "#x$x-y$y {border-color:transparent; background-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
        }
    }

    for ($x = 10; $x <= 15; $x++) {//hall
        for ($y = 1; $y <= 7; $y++) {
            echo "#x$x-y$y {border-color:transparent; background-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
        }
    }

    for ($x = 18; $x <= 25; $x++) {//lounge
        for ($y = 1; $y <= 6; $y++) {
            echo "#x$x-y$y {border-color:transparent;background-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
        }
    }

    for ($x = 1; $x <= 6; $x++) {//library
        for ($y = 7; $y <= 11; $y++) {
            echo "#x$x-y$y {border-color:transparent;background-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
        }
    }
    echo "#x7-y8 {border-color:transparent;background-color:transparent;} #x7-y8:hover {background-color:transparent;}";
    echo "#x7-y9 {border-color:transparent;background-color:transparent;} #x7-y9:hover {background-color:transparent;}";
    echo "#x7-y10 {border-color:transparent;background-color:transparent;} #x7-y10:hover {background-color:transparent;}";

    for ($x = 10; $x <= 14; $x++) {//centercluething
        for ($y = 9; $y <= 15; $y++) {
            echo "#x$x-y$y {border-color:transparent;background-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
        }
    }

    for ($x = 17; $x <= 25; $x++) {//dining room
        for ($y = 10; $y <= 15; $y++) {
            echo "#x$x-y$y {border-color:transparent;background-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
        }
    }
    echo "#x20-y16 {border-color:transparent;background-color:transparent;} #x20-y16:hover {background-color:transparent;}";
    echo "#x21-y16 {border-color:transparent;background-color:transparent;} #x21-y16:hover {background-color:transparent;}";
    echo "#x22-y16 {border-color:transparent;background-color:transparent;} #x22-y16:hover {background-color:transparent;}";
    echo "#x23-y16 {border-color:transparent;background-color:transparent;} #x23-y16:hover {background-color:transparent;}";
    echo "#x24-y16 {border-color:transparent;background-color:transparent;} #x24-y16:hover {background-color:transparent;}";

    for ($x = 1; $x <= 6; $x++) {//billiard room
        for ($y = 13; $y <= 17; $y++) {
            echo "#x$x-y$y {border-color:transparent;background-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
        }
    }
    for ($x = 1; $x <= 5; $x++) {//conservatory 
        for ($y = 20; $y <= 25; $y++) {
            echo "#x$x-y$y {border-color:transparent;background-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
        }
    }
    echo "#x6-y21 {border-color:transparent;background-color:transparent;} #x6-y21:hover {background-color:transparent;}";
    echo "#x6-y22 {border-color:transparent;background-color:transparent;} #x6-y22:hover {background-color:transparent;}";
    echo "#x6-y23 {border-color:transparent;background-color:transparent;} #x6-y23:hover {background-color:transparent;}";
    echo "#x6-y24 {border-color:transparent;background-color:transparent;} #x6-y24:hover {background-color:transparent;}";

    for ($x = 19; $x <= 24; $x++) {//kitchen 
        for ($y = 19; $y <= 24; $y++) {
            echo "#x$x-y$y {border-color:transparent;background-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
        }
    }
    for ($x = 9; $x <= 16; $x++) {//ballroom 
        for ($y = 18; $y <= 23; $y++) {
            echo "#x$x-y$y {border-color:transparent;background-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
        }
    }
    for ($x = 11; $x <= 14; $x++) {//ballroom 
        for ($y = 23; $y <= 25; $y++) {
            echo "#x$x-y$y {border-color:transparent;background-color:transparent;} #x$x-y$y:hover {background-color:transparent;}";
        }
    }



    echo '</style>';
}

function drawCharacters() {

    $theGoods = array();
    $db = getDatabase();
    $stmt = $db->prepare("SELECT * FROM characters where gameKey = :gameKey");
    $binds = array(
        ":gameKey" => $_SESSION["gameKey"],
    );
    if ($stmt->execute($binds) > 0) {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $x) {
            if ($x['CharacterID'] == 1) {
                $scarletLoc = "x" . $x['xCoord'] . "-y" . $x['YCoord'];
            } else if ($x['CharacterID'] == 2) {
                $mustardLoc = "x" . $x['xCoord'] . "-y" . $x['YCoord'];
            } else if ($x['CharacterID'] == 3) {
                $whiteLoc = "x" . $x['xCoord'] . "-y" . $x['YCoord'];
            } else if ($x['CharacterID'] == 4) {
                $greenLoc = "x" . $x['xCoord'] . "-y" . $x['YCoord'];
            } else if ($x['CharacterID'] == 5) {
                $peacockLoc = "x" . $x['xCoord'] . "-y" . $x['YCoord'];
            } else if ($x['CharacterID'] == 6) {
                $plumLoc = "x" . $x['xCoord'] . "-y" . $x['YCoord'];
            }

            echo "<style>";
            echo "#$scarletLoc {border-color:red; background-color:red;}#$scarletLoc:hover {} ";
            echo "#$mustardLoc {border-color:yellow; background-color:yellow;}#$mustardLoc:hover {} ";
            echo "#$whiteLoc {border-color:white; background-color:white;}#$whiteLoc:hover {} ";
            echo "#$greenLoc {border-color:green; background-color:green;}#$greenLoc:hover {} ";
            echo "#$peacockLoc {border-color:blue; background-color:blue;}#$peacockLoc:hover {} ";
            echo "#$plumLoc {border-color:purple; background-color:purple;}#$plumLoc:hover {} ";
            echo "</style>";
        }
    } else {
        echo"that sucks";
    }
}

function drawBlack() {
    echo "<style>";
    echo "#x7-y1 {border-color:black;background-color:black;}";
    echo "#x9-y1 {border-color:black;background-color:black;}";
    echo "#x16-y1 {border-color:black;background-color:black;}";
    echo "#x18-y1 {border-color:black;background-color:black;}";
    echo "#x1-y5 {border-color:black;background-color:black;}";
    echo "#x1-y7 {border-color:black;background-color:black;}";
    echo "#x24-y7 {border-color:black;background-color:black;}";
    echo "#x24-y9 {border-color:black;background-color:black;}";
    echo "#x1-y11 {border-color:black;background-color:black;}";
    echo "#x1-y12 {border-color:black;background-color:black;}";
    echo "#x1-y18 {border-color:black;background-color:black;}";
    echo "#x1-y20 {border-color:black;background-color:black;}";
    echo "#x24-y17 {border-color:black;background-color:black;}";
    echo "#x24-y19 {border-color:black;background-color:black;}";
    for ($x = 1; $x < 10; $x++) {
        echo "#x$x-y25 {border-color:black;background-color:black;}";
    }
    for ($x = 16; $x < 25; $x++) {
        echo "#x$x-y25 {border-color:black;background-color:black;}";
    }
    echo "</style>";
}
