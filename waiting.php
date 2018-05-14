<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="main.css">
        <meta http-equiv="refresh" content="5"/>
        <!-- Refreshes page every 15 seconds ^^^^ -->
    </head>
    <body>
        <div id="wrapper">
            <div style="width:200px; margin:auto; margin-top:15px">
                <div style="padding-top:30px;">Waiting for other players</div>
                <div style="margin:auto;" class="loader"></div>
                <?php
                session_start();
                include_once 'dbconnect.php';
                //$db = getDatabase();
                //$stmt = $db->prepare("SELECT * FROM `player` where coalesce(PlayerName) is not null ");
                //if ($stmt->execute() > 0) {
                //    $currentPlyrs = count($stmt->fetchAll(PDO::FETCH_ASSOC));
                //}
                if (filter_input(INPUT_POST, 'action') === 'create') {
                    $gameKey = $_POST['gameKey'];
                    $_SESSION['gameKey'] = $_POST['gameKey'];
                    $ownerName = $_POST['playerNameC'];
                    $_SESSION['expectedPlyrs'] = $_POST['playerNumb'];
                    $db = getDatabase();
                    $character = $_POST['characterName'];
                    //giving a characterID value to the chosen character by game creator
                    if ($character === "Scarlet") {
                        $characterID = 1;
                        $cardId = 1;
                        $xCoord = 17;
                        $yCoord = 1;
                        $characterColor = 'Scarlet';
                    } elseif ($character === "Plum") {
                        $characterID = 2;
                        $xCoord = 1;
                        $yCoord = 6;
                        $characterColor = 'Plum';
                    } elseif ($character === "Peacock") {
                        $characterID = 3;
                        $xCoord = 1;
                        $yCoord = 19;
                        $characterColor = 'Peacock';
                    } elseif ($character === "Green") {
                        $characterID = 4;
                        $xCoord = 10;
                        $yCoord = 25;
                        $characterColor = 'Green';
                    } elseif ($character === "Mustard") {
                        $characterID = 5;
                        $xCoord = 24;
                        $yCoord = 8;
                        $characterColor = 'Mustard';
                    } elseif ($character === "White") {
                        $characterID = 6;
                        $xCoord = 15;
                        $yCoord = 25;
                        $characterColor = 'White';
                    }
                    //SQL statements to create current game session
                    //---------------------------------------------
                    $stmt1 = $db->prepare("INSERT INTO game(GameKey, GameName, GameOwner, NumberOfPlayers) VALUES ('$gameKey', 'Test', '$ownerName', '$expectedPlyrs')");
                    $stmt2 = $db->prepare("INSERT INTO player(GameKey, CharacterId, PlayerName) VALUES('$gameKey', '$charcterID', '$ownerName')");
                    $stmt3 = $db->prepare("SELECT PlayerId FROM player WHERE PlayerName = '$ownerName'");
                    //---------------------------------------------

                    if ($stmt1->execute() > 0) {
                        if ($stmt2->execute() > 0) {
                            $result = array();
                            if ($stmt3->execute() > 0) {
                                $result = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $x):
                                    $_SESSION['PlayerID'] = $x['PlayerId'];
                                endforeach;
                                $stmt4 = $db->prepare("INSERT INTO characters(CharacterID, CardID, CharacterColor, xCoord, YCoord, PlayerID, gameKey) VALUES('$characterID', '$cardId', '$characterColor', '$xCoord', '$yCoord', '$playerID', '$gameKey')");
                            } else {
                                echo"Statement 3 of create game did not execute";
                            }
                        } else {
                            echo"Statement 2 of create game did not execute";
                        }
                    } else {
                        echo"Statement 1 of create game did not execute";
                    }
                    if ($stmt4->execute() > 0) {
                        ?>
                        <div style="width:170px; margin:auto;"><?php echo 'Successfully Chose ' . $character; ?></div>
                        <?php
                    } else {
                        echo"Statement 4 of create game did not execute";
                    }
                    ?>
                    <div style="width:170px; margin:auto;"><?php echo 'Game Key: ' . $gameKey; ?></div>
                    <?php
                } elseif (filter_input(INPUT_POST, 'action') === 'join') {
                    //if join game form was submitted
                    $_SESSION['joinCharacterName'] = $_POST['characterNameJ'];
                    //giving a characterID value to the chosen character by joining user
                    if ($_SESSION['joinCharacterName'] === "Scarlet") {
                        $characterID = 1;
                        $cardID = 1;
                        $xCoord = 17;
                        $yCoord = 1;
                        $characterColor = 'Scarlet';
                    } elseif ($_SESSION['joinCharacterName'] === "Plum") {
                        $characterID = 2;
                        $cardID = 2;
                        $xCoord = 1;
                        $yCoord = 6;
                        $characterColor = 'Plum';
                    } elseif ($_SESSION['joinCharacterName'] === "Peacock") {
                        $characterID = 3;
                        $cardID = 3;
                        $xCoord = 1;
                        $yCoord = 19;
                        $characterColor = 'Peacock';
                    } elseif ($_SESSION['joinCharacterName'] === "Green") {
                        $characterID = 4;
                        $cardID = 4;
                        $xCoord = 10;
                        $yCoord = 25;
                        $characterColor = 'Green';
                    } elseif ($_SESSION['joinCharacterName'] === "Mustard") {
                        $characterID = 5;
                        $cardID = 5;
                        $xCoord = 24;
                        $yCoord = 8;
                        $characterColor = 'Mustard';
                    } elseif ($_SESSION['joinCharacterName'] === "White") {
                        $characterID = 6;
                        $cardID = 6;
                        $xCoord = 15;
                        $yCoord = 25;
                        $characterColor = 'White';
                    }
                    $joinKey = $_POST['gameKeyJ'];
                    $joinPlayerName = $_POST['playerNameJ'];
                    $db = getDatabase();
                    //SQL statements to join the created game session
                    //-----------------------------------------------
                    $stmt1 = $db->prepare("INSERT INTO player(GameKey, CharacterId, PlayerName) VALUES('$joinKey', '$characterID', '$joinPlayerName')");
                    $stmt2 = $db->prepare("SELECT PlayerId FROM player WHERE PlayerName = '$joinPlayerName'");
                    //----------------------------------------------
                    if ($stmt1->execute() > 0) {
                        if ($stmt2->execute() > 0) {
                            $joinplayerID = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                            $stmt3 = $db->prepare("INSERT INTO characters(CharacterID, CardID, CharacterColor, xCoord, Ycoord, PlayerID, gameKey) VALUES ('$characterID', '$cardId', '$characterColor', '$xCoord', '$yCoord', '$joinplayerID', '$joinKey')");
                            if ($stmt3->execute() > 0) {
                                ?>
                                <div style="width:200px; margin:auto;"><?php echo "Successfully joined game"; ?></div>
                                <div style="width:200px; margin:auto;"><?php echo 'Successfully Chose ' . $_SESSION['joinCharacterName']; ?></div>
                                <?php
                            }
                        }
                    }


                    //echo "<div style='width:200px; margin:auto;'>Please Join or Create a Game.</div>";
                    //sleep(10);
                    //header("Location: index.php");
                }
                $db = getDatabase();
                $stmt = $db->prepare("SELECT COUNT(*) FROM `player` WHERE COALESCE(PlayerName) is not null and GameKey = $joinKey");
                if ($stmt->execute() > 0) {
                    $stmt2 = $db->prepare("SELECT NumberOfPlayers from game WHERE GameKey = $joinKey");
                    if ($stmt2->execute() > 0) {
                        $currentResults = $stmt->fetch(PDO::FETCH_ASSOC);
                        $expectedResults = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($currentResults as $x):
                            $currentPlyrs = $x;
                        endforeach;

                        foreach ($expectedResults as $x):
                            $expectedPlyrs = $x['NumberOfPlayers'];
                        endforeach;
                        echo 'expected' . $expectedPlyrs;
                        echo 'current' . $currentPlyrs;
                    }
                }
                if ($currentPlyrs === $expectedPlyrs) {
                    $_SESSION['mode'] = "wait";
                    //if the players expected is hit
                    //this is where we innitialize the game
                    include_once 'Initialization/Initalization.php';
                    echo "<div style='width:200px; margin:auto;>Initializing Game</div>'";
                    header("Location: gameboard.php");
                }
                ?>

                <a href="gameboard.php">HARD LINK TO GAME BOARD</a>
            </div>
        </div><!-- End of "wrapper div -->

</html>

