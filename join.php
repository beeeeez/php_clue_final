<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="main.css">
    </head>
    <body>
        <div id="wrapper">
            <div>
                <a style="width:79px; margin: 5px 0px 0px 5px; margin-top:15px;" class="btn btn-warning" href="index.php">Go back</a>
                <br/>
                <br/>
                <form method="POST" action="waiting.php">
                    <div style="width:420px; margin:auto;">
                        <label for="gameKey">Enter Game Key:</label>
                        <input type="text" name="gameKeyJ">
                        <br/>
                        <br/>
                        <label for="playerName">Name:</label>
                        <input type="text" name="playerNameJ">
                        <br/>
                        <br/>
                        <select name="characterNameJ">
                            <?php
                            include_once 'dbconnect.php';
                            $db = getDatabase();
                            $gameKey = $_POST['gameKeyJ'];
                            $stmt = $db->prepare("SELECT CharacterColor FROM `characters` WHERE PlayerID IS NULL AND gameKey = :gameKey");
                            $binds = array(
                                ":gameKey" => $firstname
                            );
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
                        <input type="hidden" name="action" value="join">
                        <input class="btn btn-primary" type="submit" value="Join Game" name="joinGame">
                    </div>
                </form>
            </div>
        </div><!-- End of "wrapper div -->
    </body>
</html>