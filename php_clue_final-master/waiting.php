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
                if (filter_input(INPUT_POST, 'action') === 'create') {
                    $gameKey = $_POST['gameKey'];
                    $_SESSION['gameKey'] = $_POST['gameKey'];
                    $ownerName = $_POST['playerNameC'];
                    $_SESSION['expectedPlyrs'] = $_POST['playerNumb'];
                    $expectedPlyrs = $_POST['playerNumb'];
                    $db = getDatabase();
                    $character = $_POST['characterNameJ'];
                    $stmt1 = $db->prepare("INSERT INTO characters(CharacterID, CardID, CharacterColor, xCoord, YCoord, gameKey) VALUES (1, 1, 'Scarlet', 17, 1, '$gameKey'), (2, 2, 'Plum', 1, 6, '$gameKey'), (3, 3, 'Peacock', 1, 19, '$gameKey'), (4, 4, 'Green', 10, 25, '$gameKey'), (5, 5, 'Mustard', 24, 8, '$gameKey'), (6, 6, 'White', 15, 25, '$gameKey')");
                    if ($stmt1->execute() > 0) {
                    echo 'success';
                    }
                    else{
                        echo'broken';
                    }
                        //giving a characterID value to the chosen character by game creator
                        if ($character === "Scarlet") {
                            $characterID = 1;
                        } elseif ($character === "Plum") {
                            $characterID = 2;
                        } elseif ($character === "Peacock") {
                            $characterID = 3;
                        } elseif ($character === "Green") {
                            $characterID = 4;
                        } elseif ($character === "Mustard") {
                            $characterID = 5;
                        } elseif ($character === "White") {
                            $characterID = 6;
                        }
                        //SQL statements to create current game session
                        //---------------------------------------------
                        echo '1';
                        $stmt7 = $db->prepare("INSERT INTO game(GameKey, GameName, GameOwner, NumberOfPlayers) VALUES ('$gameKey', 'Test', '$ownerName', '$expectedPlyrs')");
                        $stmt8 = $db->prepare("INSERT INTO player(GameKey, CharacterId, PlayerName) VALUES('$gameKey', '$characterID', '$ownerName')");
                        $stmt9 = $db->prepare("SELECT PlayerId FROM player WHERE PlayerName = '$ownerName'");
                        //---------------------------------------------
                         echo '2';
                        if ($stmt7->execute() > 0) {
                            if ($stmt8->execute() > 0) {
                                $result = array();
                                if ($stmt9->execute() > 0) {
                                    $result = $stmt9->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($result as $x):
                                        $_SESSION['PlayerID'] = $x['PlayerId'];
                                        $playerID = $x['PlayerId'];
                                    endforeach;
                                    $stmt10 = $db->prepare("UPDATE characters SET PlayerID = $playerID WHERE CharacterID = $characterID");
                                } else {
                                    echo"Statement 9 of create game did not execute";
                                }
                            } else {
                                echo"Statement 8 of create game did not execute";
                            }
                        } else {
                            echo"Statement 7 of create game did not execute";
                        }
                        if ($stmt10->execute() > 0) {
                            ?>
                            <div style="width:170px; margin:auto;"><?php echo 'Successfully Chose ' . $character; ?></div>
                            <?php
                        } else {
                            echo"Statement 10 of create game did not execute";
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
                    } elseif ($_SESSION['joinCharacterName'] === "Plum") {
                        $characterID = 2;
                    } elseif ($_SESSION['joinCharacterName'] === "Peacock") {
                        $characterID = 3;
                    } elseif ($_SESSION['joinCharacterName'] === "Green") {
                        $characterID = 4;
                    } elseif ($_SESSION['joinCharacterName'] === "Mustard") {
                        $characterID = 5;
                    } elseif ($_SESSION['joinCharacterName'] === "White") {
                        $characterID = 6;
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
                            $stmt3 = $db->prepare("Update characters SET PlayerID = $joinplayerID WHERE CharacterID = $characterID");                          
                            if ($stmt3->execute() > 0) {
                                ?>
                                <div style="width:200px; margin:auto;"><?php echo "Successfully joined game"; ?></div>
                                <div style="width:200px; margin:auto;"><?php echo 'Successfully Chose ' . $_SESSION['joinCharacterName']; ?></div>
                                <?php
                            }
                        }
                    }
                }
                $db = getDatabase();
                $stmt = $db->prepare("SELECT COUNT(*) FROM `player` WHERE COALESCE(PlayerName) is not null and GameKey = $joinKey");
                if ($stmt->execute() > 0) {
                    $stmt2 = $db->prepare("SELECT NumberOfPlayers FROM game WHERE GameKey = $joinKey");
                    if ($stmt2->execute() > 0) {
                        $currentResults = $stmt->fetch(PDO::FETCH_ASSOC);
                        $expectedResults = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($currentResults as $x):
                            $currentPlyrs = $x;
                        endforeach;

                        foreach ($expectedResults as $x):
                            $expectedPlyrs = $x['NumberOfPlayers'];
                        endforeach;
                    }
                }
                if ($currentPlyrs === $expectedPlyrs) {
                    $_SESSION['mode'] = "wait";
                    //take the creator id and make it the turn id in the turn table
                    //-----------------------------------
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

