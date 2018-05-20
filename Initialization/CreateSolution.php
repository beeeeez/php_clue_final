<?php

//include_once './ConnectDB.php';
include_once 'dbconnect.php';

//Generate Solution
//$gameKey = "1";
$gameKey = $_SESSION["gameKey"];
$murder = "";
$murderWeapon = "";
$murderLocation = "";

try {
    $conn = getDatabase();

    // set the PDO error mode to exception
    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully"; 
    $stmt = $conn->prepare("SELECT CardId FROM cards WHERE CardTypeId = 1 ORDER BY RAND() LIMIT 1 ");

    //print_r($db);
    //print_r($stmt);
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $cnt = 0;
        $_SESSION['string'] = 'poop1';
        $results = $stmt->fetchALL(PDO::FETCH_ASSOC);
        // print_r($results);;
        $murder = $results[$cnt]['CardId'];
    } else {
        echo"There are no Valid Suspects";
        $_SESSION['string'] = 'error1';
    }
} catch (PDOException $e) {

    echo "Connection failed: " . $e->getMessage();
    echo("<br>");
    $_SESSION['string'] = 'error2';
}

try {
    $conn = getDatabase();
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully"; 
    $stmt = $conn->prepare("SELECT CardId FROM cards WHERE CardTypeId = 2 ORDER BY RAND() LIMIT 1 ");
    //print_r($db);
    //print_r($stmt);
    $_SESSION['string'] = 'poop2';
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $cnt = 0;

        $results = $stmt->fetchALL(PDO::FETCH_ASSOC);
        // print_r($results);;
        $murderWeapon = $results[$cnt]['CardId'];
    } else {
        $_SESSION['string'] = 'error4';

        echo"There are no Valid Weapons";
    }
} catch (PDOException $e) {
    $_SESSION['string'] = 'error3';
    echo "Connection failed: " . $e->getMessage();
    echo("<br>");
}

try {
    $conn = getDatabase();
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully"; 
    $stmt = $conn->prepare("SELECT CardId FROM cards WHERE CardTypeId = 3 ORDER BY RAND() LIMIT 1 ");
    //print_r($db);
    //print_r($stmt);
    if ($stmt->execute() && $stmt->rowCount() > 0) {
        $cnt = 0;

        $results = $stmt->fetchALL(PDO::FETCH_ASSOC);
        // print_r($results);;
        $murderLocation = $results[$cnt]['CardId'];
    } else {
        echo"There are no Valid Locations";
    }
} catch (PDOException $e) {

    echo "Connection failed: " . $e->getMessage();
    echo("<br>");
}

try {
    $conn = getDatabase();
    // set the PDO error mode to exception
    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";     
    $stmt = $conn->prepare("INSERT INTO `gamesolution`(`GameKey`, `MurdererId`, `MurderWeaponId`, `MurderLocationId`) VALUES ('$gameKey','$murder','$murderWeapon', '$murderLocation')");
    //print_r($db);
    //print_r($stmt);
    $stmt->execute();
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    echo("<br>");
}
?>

