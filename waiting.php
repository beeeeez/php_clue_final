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
            <div style="width:155px; margin:auto; margin-top:15px">
                <div style="padding-top:30px;">Waiting for other players</div>
                <div style="margin:auto;" class="loader"></div>
                <?php
                session_start();
                include_once 'dbconnect.php';

                if (isset($_POST['createGame']) || isset($_POST['joinGame'])) {
                    $_SESSION['gameKey'] = $_POST['gameKey'];
                    $_SESSION['playerName'] = $_POST['playerName'];
                    $expectedPlyrs = $_POST['playerNumb'];
                    $result = "";
                    $db = getDatabase();
                    $stmt = $db->prepare("SELECT playercount FROM player_assignment WHERE gamekey = $gamekey");
                    if ($stmt->execute()) {
                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    }
                    while ($result < $expectedPlyrs) {
                        if (!empty($_POST['createGame'])) {
                            $playerNumb = $_POST['playerNumb'];
                            $playerName = $_POST['playerName'];
                            $db = getDatabase();
                            //this needs to be changed now that tables were reconfigured
                            $stmt1 = $db->prepare("INSERT INTO main(gamekey, playerCount, turnNumb) VALUES ('$gameKey', '$playerNumb', '0')");                            
                            $stmt2 = $db->prepare("INSERT INTO player_assignment(gamekey, Scarlet, Mustard, White, Green, Peacock, Plum) VALUES ('$gameKey' , '$playerName', ' ' , ' ', ' ', ' ', ' ')");
                            //----------------------------------------------------------------
                            $bool = false;
                            if ($stmt1->execute() > 0) {
                                $bool = true;
                                if ($bool === true && $stmt2->execute() > 0) {
                                    $bool = true;
                                }
                            }
                            ?>
                            <div style="width:170px; margin:auto;">
                                <?php
                                echo 'Game Key: ' . $gameKey;
                            } elseif (!empty($_POST['joinGame'])) {
                                include 'characterform.php';
                                $playerName = $_POST['playerName'];
                                $results = array();
                                $db = getDatabase();

                                if (isset($_POST['chooseChar'])) {
                                        $character = filter_input(INPUT_POST, 'characterName');
                                        if ($character === 'Mustard') {
                                            $stmt = $db->prepare("INSERT INTO player_assignment(Mustard) VALUE ('$playerName')");
                                            if ($stmt->execute() > 0) {
                                                echo "<div style='width:200px; margin:auto;'>You chose Mustard</div>";
                                            }
                                        } elseif ($character === 'White') {
                                            $stmt = $db->prepare("INSERT INTO player_assignment(White) VALUE ('$playerName')");
                                            if ($stmt->execute() > 0) {
                                                echo "<div style='width:200px; margin:auto;'>You chose White</div>";
                                            }
                                        } elseif ($character === 'Green') {
                                            $stmt = $db->prepare("INSERT INTO player_assignment(Green) VALUE ('$playerName')");
                                            if ($stmt->execute() > 0) {
                                                echo "<div style='width:200px; margin:auto;'>You chose Green</div>";
                                            }
                                        } elseif ($character === 'Peacock') {
                                            $stmt = $db->prepare("INSERT INTO player_assignment(Peacock) VALUE ('$playerName')");
                                            if ($stmt->execute() > 0) {
                                                echo "<div style='width:200px; margin:auto;'>You chose Peacock</div>";
                                            }
                                        } elseif ($character === 'Plum') {
                                            $stmt = $db->prepare("INSERT INTO player_assignment(Plum) VALUE ('$playerName')");
                                            if ($stmt->execute() > 0) {
                                                echo "<div style='width:200px; margin:auto;'>You chose Plum</div>";
                                            }
                                        }
                                    }
                                    ?>
                                    <div style="width:200px; margin:auto;">
                                        <?php echo "Successfully joined game"; ?>
                                    </div>
                                    <?php
                                }
                            }
                        if ($result === $expectedPlyrs) {
                            //if the players expected is hit then the gameboard will get initialized
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

