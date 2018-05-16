<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="main.css">
        <meta http-equiv="refresh" content="15"/>
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
                    $_SESSION['TURNPLAYER'] = 'THIS';
                    // SESSION variable for game key and owner name
                    $_SESSION['gameKey'] = $_POST['gameKey'];
                    $_SESSION['ownerName'] = $_POST['playerNameC'];
                    $expectedPlyrs = $_POST['playerNumb'];
                    $db = getDatabase();
                    $character = $_POST['characterName'];

                    //Initializing the character table for the current session
                    //--------------------------------------------------------
                    $stmt = $db->prepare("INSERT INTO characters(CharacterID, CardID, CharacterColor, xCoord, YCoord, gameKey) VALUES (1, 1, 'Scarlet', 17, 1, '{$_SESSION['gameKey']}'), (2, 2, 'Plum', 1, 6, '{$_SESSION['gameKey']}'), (3, 3, 'Peacock', 1, 19, '{$_SESSION['gameKey']}'), (4, 4, 'Green', 10, 25, '{$_SESSION['gameKey']}'), (5, 5, 'Mustard', 24, 8, '{$_SESSION['gameKey']}'), (6, 6, 'White', 15, 25, '{$_SESSION['gameKey']}')");
                    if ($stmt->execute() > 0) {
                        echo 'Successfully created session';
                        echo '<br/>' . '<br/>';
                    } else {
                        echo'broken';
                        echo '<br/>' . '<br/>';
                    }
                    //---------------------------------------------------------
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
                    //echo '<br/>';
                    //echo '<br/> These are for the 2nd statement' . $gameKey . $characterID . $ownerName;
                    //SQL statements to continue to create current game session
                    //-------------------------------------------------
                    $stmt1 = $db->prepare("INSERT INTO game(GameKey, GameName, GameOwner, NumberOfPlayers) VALUES ('{$_SESSION['gameKey']}', 'Test', '{$_SESSION['ownerName']}', '$expectedPlyrs')");
                    $stmt2 = $db->prepare("INSERT INTO player(GameKey, CharacterId, PlayerName) VALUES('{$_SESSION['gameKey']}', '$characterID', '{$_SESSION['ownerName']}')");
                    $stmt3 = $db->prepare("SELECT PlayerId FROM player WHERE PlayerName = '{$_SESSION['ownerName']}'");
                    //-------------------------------------------------

                    if ($stmt1->execute() > 0) {
                        if ($stmt2->execute() > 0) {
                            $result = array();
                            if ($stmt3->execute() > 0) {
                                $result = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $x) {
                                    //Assigning the player id of the creator to a 
                                    //SESSION variable
                                    //------------------------------------
                                    $_SESSION['PlayerID'] = $x['PlayerId'];
                                    //------------------------------------
                                }
                                $stmt4 = $db->prepare("UPDATE characters SET PlayerID = '{$_SESSION['PlayerID']}' WHERE CharacterID = $characterID");
                            } else {
                                echo"Statement 3 of create game did not execute";
                                echo '<br/>' . '<br/>';
                            }
                        } else {
                            echo"Statement 2 of create game did not execute";
                            echo '<br/>' . '<br/>';
                        }
                    } else {
                        echo"Statement 1 of create game did not execute";
                        echo '<br/>' . '<br/>';
                    }
                    if ($stmt4->execute() > 0) {
                        ?>
                        <div style="width:170px; margin:auto;"><?php echo 'Successfully Chose ' . $character; ?></div>
                        <?php
                    } else {
                        echo"Statement 4 of create game did not execute";
                        echo '<br/>' . '<br/>';
                    }
                } elseif (filter_input(INPUT_POST, 'action') === 'join') {
                    //Assigning the joining player game key to SESSION variable
                    //Also assigning joining player name to SESSION variable
                    //---------------------------------------------
                    $_SESSION['joinKey'] = $_POST['gameKeyJ'];
                    $_SESSION['joinPlayerName'] = $_POST['playerNameJ'];
                    //---------------------------------------------  
                    ?>
                    <form method="POST" action="#">
                        <select name="selectCharacter">
                            <?php
                            $db = getDatabase();
                            $stmt = $db->prepare("SELECT CharacterColor FROM characters WHERE gameKey = '{$_SESSION['joinKey']}' AND PlayerID IS NULL OR PlayerID = '' ");
                            $availCharacters = array();
                            if ($stmt->execute() > 0) {
                                $availCharacters = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            }
                            foreach ($availCharacters as $x):
                                ?>
                                <option value="<?php echo $x['CharacterColor'] ?>"><?php echo $x['CharacterColor'] ?></option>
                                <?php
                            endforeach;
                            ?>        
                        </select>
                        <br/>
                        <br/>
                        <input class="btn btn-primary" type="submit" name="selectCharacter1" value="Select Character">
                    </form>
                    <?php
                }//end of the action join statement
                if (!empty($_SESSION['gameKey'])) {
                    ?>
                    <div style="width:170px; margin:auto;"><?php echo 'Game Key: ' . $_SESSION['gameKey']; ?></div>
                    <?php
                }
                if (filter_input(INPUT_POST, 'selectCharacter1') === 'Select Character') {
                    $_SESSION['joinCharacterName'] = $_POST['selectCharacter'];
                    //giving a characterID value to the chosen character by joining user
                    if ($_SESSION['joinCharacterName'] === "Scarlet") {
                        $_SESSION['characterID'] = 1;
                    } elseif ($_SESSION['joinCharacterName'] === "Plum") {
                        $_SESSION['characterID'] = 2;
                    } elseif ($_SESSION['joinCharacterName'] === "Peacock") {
                        $_SESSION['characterID'] = 3;
                    } elseif ($_SESSION['joinCharacterName'] === "Green") {
                        $_SESSION['characterID'] = 4;
                    } elseif ($_SESSION['joinCharacterName'] === "Mustard") {
                        $_SESSION['characterID'] = 5;
                    } elseif ($_SESSION['joinCharacterName'] === "White") {
                        $_SESSION['characterID'] = 6;
                    }
                    //SQL statements to join the created game session
                    //-----------------------------------------------
                    $db = getDatabase();
                    $stmt1 = $db->prepare("INSERT INTO player(GameKey, CharacterId, PlayerName) VALUES('{$_SESSION['joinKey']}', '{$_SESSION['characterID']}', '{$_SESSION['joinPlayerName']}')");
                    $stmt2 = $db->prepare("SELECT PlayerId FROM player WHERE PlayerName = '{$_SESSION['joinPlayerName']}'");
                    //----------------------------------------------

                    if ($stmt1->execute() > 0) {
                        if ($stmt2->execute() > 0) {
                            //if the two statements execute it means 
                            //you joined the created session and
                            //im assigning the joining player id to SESSION variable
                            //then added that player id to the character chosen
                            //------------------------------------------------------
                            $result = $stmt2->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $x) {
                                $_SESSION['joinplayerID'] = $x['PlayerId'];
                            }
                            $stmt3 = $db->prepare("UPDATE characters SET PlayerID = '{$_SESSION['joinplayerID']}' WHERE CharacterID = $characterID");
                            if ($stmt3->execute() > 0) {
                                ?>
                                <div style="width:200px; margin:auto;"><?php echo "Successfully joined game"; ?></div>
                                <div style="width:200px; margin:auto;"><?php echo 'Successfully Chose ' . $_SESSION['joinCharacterName']; ?></div>
                                <?php
                            }
                        }
                    }
                }// end of the selectCharacter statement 
                //if the form was submitted then count get the
                //current player count using the game key from the creator
                //--------------------------------------------------------
                $db = getDatabase();
                if (filter_input(INPUT_POST, 'action') === 'create') {
                    $stmt = $db->prepare("SELECT COUNT(*) FROM `player` WHERE COALESCE(PlayerName) is not null AND GameKey = '{$_SESSION['gameKey']}'");
                    //--------------------------------------------------------    
                }
                //if the game is attempted to be joined then get the player count
                //using the joining player key
                //---------------------------------------------------------
                else {
                    $stmt = $db->prepare("SELECT COUNT(*) FROM `player` WHERE COALESCE(PlayerName) is not null AND GameKey = '{$_SESSION['joinKey']}' OR GameKey = '{$_SESSION['gameKey']}'");
                }
                //---------------------------------------------------------
                //If the statement to get player count executes then
                //Depending on if the session is being created or joined
                //were getting the expected players and the current players
                //---------------------------------------------------------
                if ($stmt->execute() > 0) {
                    if (filter_input(INPUT_POST, 'action') === 'create') {
                        $stmt2 = $db->prepare("SELECT NumberOfPlayers FROM game WHERE GameKey = '{$_SESSION['gameKey']}'");
                    } else {
                        $stmt2 = $db->prepare("SELECT NumberOfPlayers FROM game WHERE GameKey = '{$_SESSION['joinKey']}' OR GameKey = '{$_SESSION['gameKey']}'");
                    }
                    //---------------------------------------------------------
                    //Assining the current players and number of players to variables
                    //----------------------------------------------------------
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
                        echo '<br/>' . '<br/>';
                        echo 'current' . $currentPlyrs;
                    }
                    //----------------------------------------------------------
                }
                //If the expected players is hit then put the 
                //creator player id as the turn ID and then initialize
                //----------------------------------------------------------
                if ($expectedPlyrs === $currentPlyrs) {
                    $_SESSION['mode'] = 'wait';
                    if ($_SESSION['TURNPLAYER'] === 'THIS') {
                        $stmt = $db->prepare("INSERT INTO turn(TurnID, gameKey) VALUES('{$_SESSION['PlayerID']}', '{$_SESSION['gameKey']}')");
                        if ($stmt->execute() > 0) {
                            //if the players expected is hit
                            //this is where we innitialize the game
                            include_once 'Initialization/Initalization.php';
                            header("Location: gameBoard.php");
                        } else {
                            echo 'this shit is broken';
                        }
                    }   //if the players expected is hit
                    //this is where we innitialize the game
                    include_once 'Initialization/Initalization.php';
                    header("Location: gameBoard.php");
                }
                //-----------------------------------------------------------
                ?>
            </div>
        </div><!-- End of "wrapper div -->

</html>

