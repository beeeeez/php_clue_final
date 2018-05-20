<?php

setPlayerID();
setNumberofPlayer();
$_SESSION['mode'] = "wait";



function setPlayerID(){    
    $results = array();
    $db = getDatabase();
    $stmt = $db->prepare("SELECT * FROM player WHERE gameKey = :gameKey and playername = :playername ");
    $binds = array(
        ":gameKey" => $_SESSION['gameKey'],
        ":playername" => $_SESSION['playerName']
    );
    //print_r($db);
    //print_r($stmt);
    if ($stmt->execute($binds) > 0)
    {
        $results = $stmt->fetchALL(PDO::FETCH_ASSOC);
        foreach ($results as $x)
        {
            $_SESSION['PlayerID'] = $x['PlayerId'];
        }
    }    
    
    else{
         $_SESSION['PlayerID'] = 'setplayerid broke';
    }
    
}


function setNumberofPlayers()
{
    $results = array();
    $db = getDatabase();
    $stmt = $db->prepare("SELECT * from game where gameKey = :gameKey");
    $binds = array(
        ":gameKey" => $_SESSION['gameKey'],
    );
    if ($stmt->execute($binds) > 0)
    {
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as $x)
        {
            $_SESSION['numberofPlayers'] = $x['NumberOfPlayers'];
        }
    }
    else{
         $_SESSION['numberofPlayers'] = 'setnumberofplayers broke';
    }
}
