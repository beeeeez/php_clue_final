<form method="POST" action="#">
    <select name="characterNameJ">
        <?php
        $db = getDatabase();
        $stmt = $db->prepare("SELECT CharacterColor FROM characters WHERE ISNULL(PlayerID,'') = '')");
        $availCharacters = array();
        if ($stmt->execute() > 0) {
            $availCharacters = $stmt->fetch(PDO::FETCH_ASSOC);
        }
        foreach ($availCharacters as $x):
            ?>
            <option value="<?php echo $x['CharacterColor'] ?>"><?php echo $x['CharacterColor'] ?></option>
            <?php
        endforeach;
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

