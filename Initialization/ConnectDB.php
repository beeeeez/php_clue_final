<?php
function DBConnect(){
   /* $config = array(
            'DB_DNS' => 'mysql:host=ict.neit.edu;port=5500;dbname=se266_matthew',
            'DB_USER' => 'se266_matthew',
            'DB_PASSWORD' => '1345137'
        );*/
        $servername = "ict.neit.edu";
        $username = "se266_joel";
        $password = "5011648";
        //$db = new PDO($config['DB_DNS'], $config['DB_USER'], $config['DB_PASSWORD']);
        //$conn = 0;
        try {
            $conn = new PDO("mysql:host=$servername;port=5500;dbname=se266_joel", $username, $password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //echo "Connected successfully";
        }
        catch(PDOException $e)
        {
            echo "Connection failed: " . $e->getMessage();
        }
        return $conn;
}
?>