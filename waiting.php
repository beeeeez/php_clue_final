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

                //Right here is where we need to compare the key that was taken from the "join.php" page
                //To the keys that are available in the Datebase.
                //while (number of players on the server < the amount of players expected)
                //do the code below

                if (isset($_GET['createGame']) || isset($_GET['joinGame'])) {
                    if (isset($_GET['createGame'])) {
                        $gameKey = $_GET['gameKey'];
                        ?>
                        <div style="width:170px; margin:auto;">
                            <?php
                            echo 'Game Key: ' . $gameKey;
                        } elseif (isset($_GET['joinGame'])) {
                            ?>
                            <div style="width:200px; margin:auto;">
                                <?php echo "Successfully joined game"; ?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php
                } else {
                    echo "Please Join or Create a Game.";
                    sleep(10);
                    header("Location: index.php");
                }
                ?>
                
                <a href="gameboard.php">HARD LINK TO GAMEBOARD</a>
            </div>
        </div>
    </div><!-- End of "wrapper div -->

</html>

