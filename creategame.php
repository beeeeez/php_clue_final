<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="main.css">        
    </head>
    <body>
        <?php
        include 'genKey.php';
        $tempKey = generateRandomString();
        ?>
        <div id="wrapper">
            <div style="margin-top:15px;">
                <a style="width:79px; margin: 5px 0px 0px 5px; margin-top:15px;" class="btn btn-warning" href="index.php">Go back</a>
                <br/>
                <br/>
                <form method="get" action="waiting.php">
                    <div style="width:420px; margin:auto;">
                        <label for="playerNumb">Number of players:</label>
                        <input type="text" name="playerNumb">                
                        <input class="btn btn-primary" type="submit" name="createGame" value="Create Game">
                        <input type="hidden" value="<?php echo $tempKey ?>" name="gameKey">
                    </div>
                </form>
            </div>
        </div><!-- End of "wrapper div -->
    </body>
</html>

