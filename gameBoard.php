<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <style>
            body {
                background-image: url('cluepic1.jpg');
            }
            .grid{
                width:25px;
                height:25px;
                border-style:solid;
                border-width:1px;
                border-color:black;
                background-color:bisque;
            }
            .grid:hover{
                border-color:white;     
            }
            .row{
                height:25px;
                float:left;
            }
            .board-wrapper{
                width:651px;
                height:676px;
                float:left;
                margin:3%;
                background: url('clue_board.jpg');
            }
            .chat{
                width:300px;
                height:200px;
                margin:2%;
                float:left;
                border-style:solid;
                border-width:1px;
                border-color:black;
            }
            .whole-wrapper{
                float:left;
                width:80%;
                margin:1%;
                background-color:white;
            }
            .dice-rolls{
                width:15%;
                float:left;
                margin:5%;                   
                border-style:solid;
                border-width:1px;
                border-color:black;
            }
            #modeDraw{
                width:500px;
                height:150px;
                float:left;
                margin:3%;                   
                border-style:solid;
                border-width:1px;
                border-color:black;
                text-align:center;
            }


        </style>
    </head>

    <body>

        <div class="whole-wrapper">

            <div class="board-wrapper">
                <?php
                $_SESSION["gameKey"] = 66;
                $_SESSION["PlayerID"] = 6;
                $_SESSION['mode'] = "move";

                include 'stateFinder.php';
                include 'drawRooms.php';
                include 'dbconnect.php';
                movementCheck();
                drawGrid();
                drawRooms();
                drawBlack();
                drawCharacters();


                //findState();
                //drawRooms();
                //drawBlack();
                ?></div>
            <div class="custom"></div>

            <div id="modeDraw">
                <?php
                findState();
                ?>
            </div>

            <div class="hand">
            </div>
        </div>
    </body>
</html>