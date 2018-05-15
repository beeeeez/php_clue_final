<form method="POST" action="#">
    <select name="characterName">
        <?php
        //need to rewrite the sql statement to work with the new tables
        //just need it to check what characters have not been chosen yet
        //the ones that have not been chosen will be displayed
        //----------------------------------------------------
        //the way it's being done now is it's just checking to see if the fields are
        //' ' if they are then it is displayed
        //Select c.CardName from cards c LEFT JOIN player p on c.cardID = p.CharacterId Where c.CardTypeId = 1 AND p.CharacterId is NULL
        $results = array();
        $db = getDatabase();
        //Need to change this to pull in the unselected characters
        $stmt = $db->prepare("SELECT Mustard, White, Green, Peacock, Plum FROM player_assignment WHERE gamekey = $gameKey");
        //---------------------------------------------------------
        if ($stmt->execute() > 0) {
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($results as $x) {
                $Mustard = $x['Mustard'];
                $White = $x['White'];
                $Green = $x['Green'];
                $Peacock = $x['Peacock'];
                $Plum = $x['Plum'];
            }
            if ($Mustard === ' ') {
                echo "<option value='Mustard'>Mustard</option>";
            } elseif ($White === ' ') {
                echo "<option value='White'>White</option>";
            } elseif ($Green === ' ') {
                echo "<option value='Green'>Green</option>";
            } elseif ($Peacock === ' ') {
                echo "<option value='Peacock'>Peacock</option>";
            } elseif ($Plum === ' ') {
                echo "<option value='Plum'>Plum</option>";
            }
        }
        ?>
    </select>
    <input type="hidden" name="action" value="chooseChar">
    <input type="submit" class="btn-primary" value="Make Selection">
</form>
<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

