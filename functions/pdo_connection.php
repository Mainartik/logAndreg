<?php

$serverName = 'localhost';
$userName = 'root';
$password = '';

try
{
        $options = [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        $pdo = new PDO("mysql:host=$serverName;", $userName, $password, $options);
    
              
                $sql=  "CREATE DATABASE php_tutorial";
                $pdo->exec($sql);
                echo "created";
        
    

        // $user['name']
        // $user->name;

}
catch (\Exception $e){
        echo 'errors : ' . $e->getMessage();
}
