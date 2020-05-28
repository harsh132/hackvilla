<?php
require_once "../utils.php";
checklogin('admin');
if(!isset($_GET["id"]) || $_GET["id"]=="")
{
    $_SESSION['msg']='<p style="font-size:150px">&#128543;</p><div class="alert alert-danger">Organiser not found.</div>';
    header('location:dashboard.php');
    return;
}
$id=htmlentities($_GET['id']);
if(isset($_GET['u']) && $_GET['u']=='unblock')
{
    execSQL('UPDATE organisers SET status=1 WHERE id=?',array($id));
    header('location:organisers.php');
}
else
{
    execSQL('UPDATE organisers SET status=2 WHERE id=?',array($id));
    header('location:organisers.php');
}
?>