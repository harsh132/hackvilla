<?php
require_once '../conn.php';
$stmt = $conn->prepare('SELECT name FROM institutions WHERE name LIKE :prefix LIMIT 7');
$stmt->execute(array( ':prefix' => "%".$_REQUEST['term']."%"));
$retval = array();
while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
  $retval[] = $row['name'];
}
echo(json_encode($retval, JSON_PRETTY_PRINT));
?>