<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
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
            }
            .grid:hover{
                background-color:black;                  
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
            .hand{
                width:500px;
                height:150px;
                float:left;
                margin:3%;                   
                border-style:solid;
                border-width:1px;
                border-color:black;
            }
            .suggestion{
                height:150px;
                float:left;
                margin:3%;                   
                border-style:solid;
                border-width:1px;
                border-color:black;
                text-align:center;
                padding:1%;
            }

        </style>
    </head>

    <body>

        <div class="whole-wrapper">

            <div class="board-wrapper">
                <?php
                include 'drawrooms.php';
                drawGrid();
                drawRooms();
                //drawRooms();
                //drawBlack();
                ?></div>
            <div class="chat">
                <p>The chatlog goes here!</p>
            </div>
            <div class="dice-rolls">
                <img src="dice/1.png" />  <img src="dice/1.png" /> 
            </div><br />
            <div class="hand">
                <p>Your hand goes here!</p>
            </div>

            <div class="suggestion"><h3>Suggestion : </h3>
                <form>
                    <label>Suspect : </label>
                    <select name="suspect">
                        <option value="Ms. Scarlet">Ms. Scarlet</option>
                        <option value="Mrs. White">Mrs. White</option>
                        <option value="Prof. Plum">Prof. Plum</option>
                    </select>
                    <label>Weapon : </label>
                    <select name="weapon">
                        <option value="Knife">Knife</option>
                        <option value="Rope">Rope</option>
                        <option value="Revolver">Revolver</option>
                    </select>
                    <label>Location : </label>
                    <select name="location">
                        <option value="Study">Study</option>
                        <option value="Billiard Room">Billiard Room</option>
                        <option value="Conservatory">Conservatory</option>
                    </select>

            </div>
        </div>
    </body>
</html>