<?php
// $_SESSION['mode'] === suggest, $_SESSION['accuse'] 
// this is what launches the suggest and accusation 


function compareSolSugg($gameMode, $suspect, $weapon, $location){
    if ($gameMode === 'suggest' || $gameMode === 'accuse'){
        $suspectSol = '';
        $weaponSol = '';
        $locationSol = '';
        include_once 'dbconnect.php';
        $db = getDatabase();
        $stmt = $db->prepare("SELECT MurdererId, MurderWeaponId, MurderLocationId FROM gamesolution WHERE GameKey = '{$_SESSION['gameKey']}' OR GameKey = '{$_SESSION['joinKey']}'");
        
        if($stmt->execute() && $stmt->rowCount() > 0 ){
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($results as $x){
                $suspectSol = $x['MurdererId'];
                $weaponSol = $x['MurderWeaponId'];
                $locationSol = $x['MurderLocationId'];
            }            
        }else{
            echo "Could not pull the solution from suggestion.php compSolSugg function";
        }
        $check = checkSol($suspectSol, $weaponSol, $locationSol, $suspect, $weapon, $location);
    }else{
        echo "This is not a suggestion or an acusation (From suggestion.php) compSolSugg function";
    }
    return $check;
}

function checkSol($suspectSol, $weaponSol, $locationSol, $suspect, $weapon, $location){
     $check = false;
        if($suspectSol === $suspect){
            $check = true;
            if($weaponSol === $weapon){
                $check = true;
                if($locationSol === $location){
                    $check = true;
                }else{
                    $check = false;
                }
            }else{
                $check = false;
            }
        }else{
            $check = false;
        }        
    return $check;
}
