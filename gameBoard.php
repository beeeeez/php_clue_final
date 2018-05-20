<!DOCTYPE html>

<html>
    <head>
        <?php
        session_start();
                include 'dbconnect.php';
        include 'stateFinder.php';
        include 'drawRooms.php';
        movementCheck();
        if($_SESSION['mode'] == "wait"){
            echo '<meta http-equiv="refresh" content="15">';
                    }
        ?>
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
                
            }


        </style>
    </head>

    <body>

        <div class="whole-wrapper">

            <div class="board-wrapper">
                <?php                 

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
                if(isset($_SESSION['prevRoom'])){
                    print_r($_SESSION['prevRoom']);
                }
                if(isset($_POST['updateX'])){
                    echo"<br>Update X :";
                    echo $_POST['updateX'];
                       echo"<br>Update Y :";
                    echo $_POST['updateY'];
                }
                echo "<br>PlayerID:";
                    echo $_SESSION ['PlayerID'];
                    echo "<br>PlayerName:";
                   
    echo $_SESSION['playerName'];
    echo "<br>GameKey:";
    echo $_SESSION['gameKey'];
    echo "<br>Mode:";
    echo $_SESSION['mode'];
    echo "<br>Number of Players : ";

    echo $_SESSION['numberofPlayers'];
    
    echo "<br>PlayerList:";
    print_r($_SESSION['playerList']);

                ?>
            </div>

            <div class="hand">
                <?php 
                drawHand();                
                ?>
            </div>
        </div>
    </body>
</html>