<?php
require_once "../utils.php";
$h='<title>Dashboard</title>';
require_once "../templates/template.php";
echo $head;
foreach($_SESSION as $s)
echo $s.'<br>';
echo $foot;
?>
<a href="logout.php">Log Out</a>