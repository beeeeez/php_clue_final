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
                <form method="POST" action="characterform.php">
                    <div style="width:420px; margin:auto;">
                        <label for="gameKey">Enter Game Key:</label>
                        <input type="text" name="gameKeyJ">
                        <br/>
                        <br/>
                        <label for="playerName">Name:</label>
                        <input type="text" name="playerNameJ">
                        <br/>
                        <br/>                       
                        <input class="btn btn-primary" type="submit" value="Join Game" name="joinGame">
                    </div>
                </form>
            </div>
        </div><!-- End of "wrapper div -->
    </body>
</html>