<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="main.css">
    </head>
    <body>
        <div id="wrapper">
            <div id="suggestion">
                
                 <form method="POST" action="suggestion.php">    
                <div class="row">
                <div class="col-sm-4">
                    <p>
                        Select a player:
                        <select name ="formPlayer">
                            <option value="">Select...</option>
                            <option value="1">Miss Scarlet</option>
                            <option value="2">Professor Plum</option>
                            <option value="3">Mrs. Peacock</option>
                            <option value="4">Mr. Green</option>
                            <option value="5">Colonel Mustard</option>
                            <option value="6">Mrs. White</option>
                        </select>
                    </p>
                </div>
                     <div class="col-sm-4">
                    <p>
                        Select a Weapon:
                        <select name ="formWeapon">
                            <option value="">Select...</option>
                            <option value="7">Candlestick</option>
                            <option value="8">Knife</option>
                            <option value="9">Lead Pipe</option>
                            <option value="10">Revolver</option>
                            <option value="11">Rope</option>
                            <option value="12">Wrench</option>
                              </select>
                    </p>
                     </div>
                     <div class="col-sm-4">
                    <p>
                        Select a Room:
                        <select name ="formRoom">
                            <option value="">Select...</option>
                            <option value="13">Ballroom</option>
                            <option value="14">Kitchen</option>
                            <option value="15">Conservatory</option>
                            <option value="16">Library</option>
                            <option value="17">Billiard Room</option>
                            <option value="18">Study</option>
                            <option value="19">Hall</option>
                            <option value="20">Lounge</option>
                            <option value="21">Dining Room</option>
                        </select>                                                   
                    </p>
                     </div>
                </div> 
                    <input class="btn btn-primary" type="submit" name="suggestion" value="Make Suggestion">
               
                 </form> 
                
                
                
                <?php ?>
                
                
                                 <form method="POST" action="accusation.php.php">    
                <div class="row">
                <div class="col-sm-4">
                    <p>
                        Select a player:
                        <select name ="formPlayer">
                            <option value="">Select...</option>
                            <option value="1">Miss Scarlet</option>
                            <option value="2">Professor Plum</option>
                            <option value="3">Mrs. Peacock</option>
                            <option value="4">Mr. Green</option>
                            <option value="5">Colonel Mustard</option>
                            <option value="6">Mrs. White</option>
                        </select>
                    </p>
                </div>
                     <div class="col-sm-4">
                    <p>
                        Select a Weapon:
                        <select name ="formWeapon">
                            <option value="">Select...</option>
                            <option value="7">Candlestick</option>
                            <option value="8">Knife</option>
                            <option value="9">Lead Pipe</option>
                            <option value="10">Revolver</option>
                            <option value="11">Rope</option>
                            <option value="12">Wrench</option>
                              </select>
                    </p>
                     </div>
                     <div class="col-sm-4">
                    <p>
                        Select a Room:
                        <select name ="formRoom">
                            <option value="">Select...</option>
                            <option value="13">Ballroom</option>
                            <option value="14">Kitchen</option>
                            <option value="15">Conservatory</option>
                            <option value="16">Library</option>
                            <option value="17">Billiard Room</option>
                            <option value="18">Study</option>
                            <option value="19">Hall</option>
                            <option value="20">Lounge</option>
                            <option value="21">Dining Room</option>
                        </select>                                                   
                    </p>
                     </div>
                </div> 
                    <input class="btn btn-primary" type="submit" name="accusation" value="Make an Accusation">
               
                 </form> 
            
                
            </div>
        </div><!-- End of "wrapper div -->
    </body>
</html>

