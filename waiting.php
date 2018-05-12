<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="main.css">
        <meta http-equiv="refresh" content="7"/>
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

                if (isset($_POST['createGame']) || isset($_POST['joinGame'])) {
                    //Collect all from players where playername is not empty
                    //Then count the number of rows and that is amount of current player in session
                    //---------------------------------------------------------
                    $stmt = $db->prepare("SELECT * FROM `player` where coalesce(PlayerName) is not null ");
                    if ($stmt->execute() > 0) {
                        $currentPlyrs = count($stmt->fetchAll(PDO::FETCH_ASSOC));
                    }
                    //--------------------------------------------------------
                    $_SESSION['ownerName'] = $_POST['playerNameC'];
                    //if create game form was submitted
                    if (!empty($_POST['createGame'])) {
                        $gameKey = $_POST['gameKey'];
                        $ownerName = $_POST['playerNameC'];
                        $expectedPlyrs = $_POST['playerNumb'];
                        $db = getDatabase();
                        include_once 'creatorcharacterform.php';
                        $character = $_POST['characterName'];
                        //giving a characterID value to the chosen character by game creator
                        if ($character === "Scarlet") {
                            $charcterID = 1;
                        } elseif ($character === "Plum") {
                            $charcterID = 2;
                        } elseif ($character === "Peacock") {
                            $charcterID = 3;
                        } elseif ($character === "Green") {
                            $charcterID = 4;
                        } elseif ($character === "Mustard") {
                            $charcterID = 5;
                        } elseif ($character === "White") {
                            $charcterID = 6;
                        }
                        //SQL statements to create current game session
                        //---------------------------------------------
                        $stmt1 = $db->prepare("INSERT INTO game(GameKey, GameName, GameOwner, NumberOfPlayers) VALUES ('$gameKey', 'Test', '$ownerName, '$expectedPlyrs')");
                        $stmt2 = $db->prepare("INSERT INTO player(GameKey, CharacterId, PlayerName) VALUES('$gameKey', '$charcterID', '$ownerName')");
                        $stmt3 = $db->prepare("SELECT PlayerId FROM player WHERE PlayerName = $ownerName");
                        //---------------------------------------------

                        if ($stmt1->execute() > 0) {
                            if ($stmt2->execute() > 0) {
                                if ($stmt3->execute() > 0) {
                                    $playerID = $stmt3->fetch(PDO::FETCH_ASSOC);
                                    $stmt4 = $db->prepare("INSERT INTO characters(PlayerID) VALUES('$playerID') WHERE CharcterID = $charcterID");
                                }
                            }
                        }
                        if ($stmt4->execute() > 0) {
                            ?>
                            <div style="width:170px; margin:auto;"><?php echo 'Successfully Chose ' . $character; ?></div>
                            <?php
                        }
                        ?>
                        <div style="width:170px; margin:auto;"><?php echo 'Game Key: ' . $gameKey; ?></div>
                        <?php
                    }
                    while ($currentPlyrs < $expectedPlyrs) {
                        //if join game form was submitted
                        if (!empty($_POST['joinGame'])) {
                            include_once 'joinercharacterform.php';
                            $joinCharacterName = $_POST['characterNameJ'];
                            //giving a characterID value to the chosen character by joining user
                            if ($joinCharacterName === "Scarlet") {
                                $characterID = 1;
                            } elseif ($joinCharacterName === "Plum") {
                                $characterID = 2;
                            } elseif ($joinCharacterName === "Peacock") {
                                $characterID = 3;
                            } elseif ($joinCharacterName === "Green") {
                                $characterID = 4;
                            } elseif ($joinCharacterName === "Mustard") {
                                $characterID = 5;
                            } elseif ($joinCharacterName === "White") {
                                $characterID = 6;
                            }
                            $joinKey = $_POST['gameKeyJ'];
                            $joinPlayerName = $_POST['playerNameJ'];
                            $db = getDatabase();
                            //SQL statements to join the created game session
                            //-----------------------------------------------
                            $stmt1 = $db->prepare("INSERT INTO player(GameKey, CharacterId, PlayerName) VALUES('$joinKey', '$characterID', '$joinPlayerName')");
                            $stmt2 = $db->prepare("SELECT PlayerId FROM player WHERE PlayerName = $joinPlayerName");
                            //-----------------------------------------------
                            ?>
                            <div style="width:200px; margin:auto;">
                                <?php echo "Successfully joined game"; ?>
                            </div>
                            <?php
                            if ($stmt1->execute() > 0) {
                                if ($stmt2->execute() > 0) {
                                    $joinplayerID = $stmt2->fetch(PDO::FETCH_ASSOC);
                                    $stmt3 = $db->prepare("INSERT INTO characters(PlayerID) VALUES($joinplayerID) WHERE CharcterID = $characterID");
                                    if ($stmt3->execute() > 0) {
                                        ?>
                                        <div style="width:170px; margin:auto;"><?php echo 'Successfully Chose ' . $joinCharacterName; ?></div>
                                        <?php
                                    }
                                }
                            }
                        }
                        $stmt = $db->prepare("SELECT * FROM `player` where coalesce(PlayerName) is not null ");
                        if ($stmt->execute() > 0) {
                            $currentPlyrs = count($stmt->fetchAll(PDO::FETCH_ASSOC));
                        }
                        if ($currentPlyrs === $expectedPlyrs) {
                            //if the players expected is hit
                            //this is where we innitialize the game
                            include_once 'Initialization/Initalization.php';
                            echo "<div style='width:200px; margin:auto;>Initializing Game</div>'";
                            header("Location: gameboard.php");
                        }
                    }
                } else {
                    echo "<div style='width:200px; margin:auto;'>Please Join or Create a Game.</div>";
                    sleep(10);
                    header("Location: index.php");
                }
                ?>

                <a href="gameboard.php">HARD LINK TO GAME BOARD</a>
            </div>
    </div><!-- End of "wrapper div -->

</html>

