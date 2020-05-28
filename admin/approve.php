<?php
require_once "../utils.php";
checklogin('admin');
if(!isset($_GET["id"]) || $_GET["id"]=="")
{
    $_SESSION['msg']='<p style="font-size:150px">&#128543;</p><div class="alert alert-danger">Contest not found.</div>';
    header('location:dashboard.php');
    return;
}
$id=htmlentities($_GET['id']);
execSQL('UPDATE hackathons SET status=1 WHERE id=?',array($id));
header('location:hackathons.php');
?>