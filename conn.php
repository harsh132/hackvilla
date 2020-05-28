<?php
$servername = "localhost";

// $username = "id13859954_user";
// $password = "1357924680@Hak";
// $db = "id13859954_hakvilla";

$username = "hp";
$password = "hp";
$db = "hackcovid";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }
?>
