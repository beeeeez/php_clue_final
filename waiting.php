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
            <div style="width:155px; margin:auto; margin-top:15px">
                <div style="padding-top:30px;">Waiting for other players</div>
                <div style="margin:auto;" class="loader"></div>
                <?php
                session_start();
                include_once 'dbconnect.php';

                if (isset($_GET['createGame']) || isset($_GET['joinGame'])) {
                    $gameKey = $_GET['gameKey'];
                    $expectedPlyrs = $_GET['playerNumb'];
                    $result = "";
                    $db = getDatabase();
                    $stmt = $db->prepare("SELECT playercount FROM player_assignment WHERE gamekey = $gamekey");

                    if ($stmt->execute()) {
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    }
                    while ($result < $expectedPlyrs) {
                        if (!empty($_GET['createGame'])) {
                            $playerNumb = $_GET['playerNumb'];
                            $playerName = $_GET['playerName'];
                            $db = getDatabase();
                            $stmt1 = $db->prepare("INSERT INTO main(gamekey, playerCount, turnNumb) VALUES ('$gameKey', '$playerNumb', '0')");
                            $stmt2 = $db->prepare("INSERT INTO player_assignment(gamekey, Scarlet, Mustard, White, Green, Peacock, Plum) VALUES ('$gameKey' , '$playerName', ' ' , ' ', ' ', ' ', ' ',)");

                            if ($stmt1->execute()) {
                                if ($stmt2->execute()) {
                                    //then set this persons position to the first spot
                                    //and make it so if that first spot is taken then
                                    //take the second spot, if thats taken take next available spot
                                    //and so on. 
                                }
                            }
                            ?>
                            <div style="width:170px; margin:auto;">
                                <?php
                                echo 'Game Key: ' . $gameKey;
                            } elseif (!empty($_GET['joinGame'])) {
                                $playerName = $_GET['playerName'];
                                $results = array();
                                $db = getDatabase();
                                $stmt = $db->prepare("SELECT * FROM player_assignment WHERE gamekey = $gameKey");

                                if ($stmt->execute()) {
                                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($results as $x) {
                                        $Mustard = $x['Mustard'];
                                        $White = $x['White'];
                                        $Green = $x['Green'];
                                        $Peacock = $x['Peacock'];
                                        $Plum = $x['Plum'];
                                    }
                                    if ($Mustard === ' ') {
                                        ?>
                                        <div style="width:200px; margin:auto">Your Character is Mr.Mustard</div>
                                        <?php
                                        $stmt = $db->prepare("INSERT INTO player_assignment(Mustard, playercount) VALUE ('$playerName', '2')");
                                        $stmt->execute();
                                    } elseif ($White === ' ') {
                                        ?>
                                        <div style="width:200px; margin:auto">Your Character is Mr.White</div>
                                        <?php
                                        $stmt = $db->prepare("INSERT INTO player_assignment(White, playercount) VALUE ('$playerName', '3')");
                                        $stmt->execute();
                                    } elseif ($Green === ' ') {
                                        ?>
                                        <div style="width:200px; margin:auto">Your Character is Mr.Green</div>
                                        <?php
                                        $stmt = $db->prepare("INSERT INTO player_assignment(Green, playercount) VALUE ('$playerName', '4')");
                                        $stmt->execute();
                                    } elseif ($Peacock === ' ') {
                                        ?>
                                        <div style="width:200px; margin:auto">Your Character is Mr.Peacock</div>
                                        <?php
                                        $stmt = $db->prepare("INSERT INTO player_assignment(Peacock, playercount) VALUE ('$playerName', '5')");
                                        $stmt->execute();
                                    } elseif ($Plum === ' ') {
                                        ?>
                                        <div style="width:200px; margin:auto">Your Character is Mr.Plum</div>
                                        <?php
                                        $stmt = $db->prepare("INSERT INTO player_assignment(Plum, playercount) VALUE ('$playerName', '6')");
                                        $stmt->execute();
                                    }
                                }
                                //$stmt1 = $db->prepare("WHERE gamekey = $gameKey INSERT INTO player_assignment(gamekey, playerCount, turnNumb) VALUES ('$gameKey', '$playerNumb', '0')");
                                ?>
                                <div style="width:200px; margin:auto;">
                                    <?php echo "Successfully joined game"; ?>
                                </div>
                                <?php
                            }
                        }
                        if ($result === $expectedPlyrs) {
                            header("Location: gameboard.php");
                        }
                        ?>
                    </div>
                    <?php
                } else {
                    echo "Please Join or Create a Game.";
                    sleep(10);
                    header("Location: index.php");
                }
                ?>

                <a href="gameboard.php">HARD LINK TO GAME BOARD</a>
            </div>
        </div>
    </div><!-- End of "wrapper div -->

</html>

