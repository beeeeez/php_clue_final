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
                    $_SESSION['playerName'] = $_POST['playerNameC'];
                    $_SESSION['expectedPlyrs'] = $_POST['playerNumb'];
                   
                    $db = getDatabase();
                    $character = $_POST['characterName'];
                    $_SESSION['characterName'] = $_POST['characterName'];
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
                    $stmt1 = $db->prepare("INSERT INTO game(GameKey, GameName, GameOwner, NumberOfPlayers) VALUES ('{$_SESSION['gameKey']}', 'Test', '{$_SESSION['ownerName']}', '{$_SESSION['expectedPlyrs']}')");
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
                                $stmt4 = $db->prepare("UPDATE characters SET PlayerID = '{$_SESSION['PlayerID']}' WHERE CharacterID = $characterID AND GameKey = '{$_SESSION['gameKey']}'");
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
                    ?>
                    <div style="width:170px; margin:auto;"><?php echo 'Game Key: ' . $_SESSION['gameKey']; ?></div>
                    <?php
                } elseif (filter_input(INPUT_POST, 'action') === 'join') {
                    //Assigning the joining player game key to SESSION variable
                    //Also assigning joining player name to SESSION variable
                    //---------------------------------------------
                    $_SESSION['joinKey'] = $_POST['gameKeyJ'];
                    $_SESSION['gameKey'] = $_POST['gameKeyJ'];
                    $_SESSION['joinPlayerName'] = $_POST['playerNameJ'];
                    $_SESSION['playerName'] = $_POST['playerNameJ'];
                    
                    //---------------------------------------------  
                    ?>
                    <form method="POST" action="#">
                        <select name="selectCharacter">
                            <?php
                            $db = getDatabase();
                            $stmt = $db->prepare("SELECT CharacterColor FROM characters WHERE gameKey = '{$_SESSION['gameKey']}' AND PlayerID IS NULL OR PlayerID = '' ");
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
                                $_SESSION['PlayerID'] = $x['PlayerId'];
                            }
                            $stmt3 = $db->prepare("UPDATE characters SET PlayerID = {$_SESSION['PlayerID']} WHERE CharacterID = '{$_SESSION['characterID']}' AND GameKey = '{$_SESSION['gameKey']}'");
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
                    $stmt = $db->prepare("SELECT COUNT(*) FROM `player` WHERE COALESCE(PlayerName) is not null AND GameKey = '{$_SESSION['gameKey']}'");
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
                        $stmt2 = $db->prepare("SELECT NumberOfPlayers FROM game WHERE GameKey = '{$_SESSION['gameKey']}'");
                    }
                    //---------------------------------------------------------
                    //Assining the current players and number of players to variables
                    //----------------------------------------------------------
                    $_SESSION['playerList'] = array();
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
                    echo "<br />Player ID:";
                    echo $_SESSION['PlayerID'];
                    echo "<br />gameKey:";
                    echo $_SESSION['gameKey'];
                    //----------------------------------------------------------
                }
                //If the expected players is hit then put the 
                //creator player id as the turn ID and then initialize
                //----------------------------------------------------------
                if ($expectedPlyrs === $currentPlyrs) {

                    if ($_SESSION['TURNPLAYER'] === 'THIS') {
                        unset($_SESSION['TURNPLAYER']);
                        $stmt = $db->prepare("INSERT INTO turn(TurnID, gameKey) VALUES('{$_SESSION['PlayerID']}', '{$_SESSION['gameKey']}')");
                        if ($stmt->execute() > 0) {
                            //if the players expected is hit
                            //this is where we innitialize the game
                           // include_once 'Initialization/Initalization.php';
                           include_once 'Initialization/CreateSolution.php';
                           include_once 'Initialization/CreatePlayerHand.php';
                           // include 'setSessionVariables.php';
                            $_SESSION['mode'] = "wait";
                            setPlayerList();
                            setNumberofPlayers();
                            header("Location: gameBoard.php");
                        } else {
                            echo 'this shit is broken';
                        }
                    }   //if the players expected is hit
                    //this is where we innitialize the game
                    
                    else{
                        //  include 'setSessionVariables.php';
                        setPlayerList();
                        setNumberofPlayers();
                        
                        $_SESSION['mode'] = "wait";
                    header("Location: gameBoard.php");
                    }
                }
                
                
function setPlayerID(){    
    $results = array();
    $db = getDatabase();
    $stmt = $db->prepare("SELECT * FROM player WHERE gameKey = :gameKey and playername = :playername ");
    $binds = array(
        ":gameKey" => $_SESSION['gameKey'],
        ":playername" => $_SESSION['playerName']
    );
    //print_r($db);
    //print_r($stmt);
    if ($stmt->execute($binds) > 0)
    {
        $results = $stmt->fetchALL(PDO::FETCH_ASSOC);
        foreach ($results as $x)
        {
            $_SESSION['PlayerID'] = $x['PlayerId'];
        }
    }    
    
    else{
         $_SESSION['PlayerID'] = 'setplayerid broke';
    }
}

function setPlayerList(){
    $_SESSION['playerList'] = array();
      echo '<br />fuck fuck fuck';
    $results = array();
     $db = getDatabase();
    $stmt = $db->prepare("SELECT * FROM player WHERE GameKey = :gameKey");
$binds = array(
        ":gameKey" => $_SESSION['gameKey'],
      
    );
    //print_r($db);
    print_r($stmt);

    if ($stmt->execute($binds) > 0)
    {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($results as $key=>$value){
            echo $key['PlayerId'];
            $_SESSION['playerList'] += array( $key => $value['PlayerId']); 
            
        }
    }
    else{
        echo 'fuck fuck fuck';
        
    }

    
    }
    
    

function setNumberofPlayers()
{
    $results = array();
    $db = getDatabase();
    $stmt = $db->prepare("SELECT * from game where gameKey = :gameKey");
    $binds = array(
        ":gameKey" => $_SESSION['gameKey'],
    );
    if ($stmt->execute($binds) > 0)
    {
        $results = $stmt->fetch(PDO::FETCH_ASSOC);

            $_SESSION['numberofPlayers'] = $results['NumberOfPlayers'];
        
    }
    else{
         $_SESSION['numberofPlayers'] = 'setnumberofplayers broke';
    }
}
    

    
                //-----------------------------------------------------------
                ?>

                <a href="gameboard.php">HARD LINK TO GAME BOARD</a>
            </div>
        </div><!-- End of "wrapper div -->

</html>

