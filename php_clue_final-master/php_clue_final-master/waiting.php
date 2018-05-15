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
                $db = getDatabase();
                $stmt = $db->prepare("SELECT * FROM `player` where coalesce(PlayerName) is not null ");
                if ($stmt->execute() > 0) {
                    $currentPlyrs = count($stmt->fetchAll(PDO::FETCH_ASSOC));
                }
                if (filter_input(INPUT_POST, 'action') === 'create') {
                    //Collect all from players where playername is not empty
                    //Then count the number of rows and that is amount of current player in session
                    //---------------------------------------------------------
                    //--------------------------------------------------------
                    //if create game form was submitted                    
                    $gameKey = $_POST['gameKey'];
                    $ownerName = $_POST['playerNameC'];
                    $_SESSION['expectedPlyrs'] = $_POST['playerNumb'];
                    $db = getDatabase();
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
                                    $playerID = $x['PlayerId'];
                                endforeach;
                                $stmt4 = $db->prepare("UPDATE characters SET PlayerID = $playerID WHERE CharacterID = $charcterID");
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
                    } elseif ($_SESSION['joinCharacterName'] === "Plum") {
                        $characterID = 2;
                    } elseif ($_SESSION['joinCharacterName'] === "Peacock") {
                        $characterID = 3;
                    } elseif ($_SESSION['joinCharacterName'] === "Green") {
                        $characterID = 4;
                    } elseif ($_SESSION['joinCharacterName'] === "Mustard") {
                        $_SESSION['joinCharacterName'] = 5;
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
                            $stmt3 = $db->prepare("UPDATE `characters` SET PlayerID = $joinplayerID WHERE CharcterID = $characterID");
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
                        echo'POOP';
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
                    echo 'shit';
                    //if the players expected is hit
                    //this is where we innitialize the game
                    include_once 'Initialization/Initalization.php';
                    echo "<div style='width:200px; margin:auto;>Initializing Game</div>'";
                    sleep(10);
                    header("Location: gameboard.php");
                }
                ?>

                <a href="gameboard.php">HARD LINK TO GAME BOARD</a>
            </div>
        </div><!-- End of "wrapper div -->

</html>

