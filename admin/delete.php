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
if($_SERVER["REQUEST_METHOD"]== "POST" && isset($_POST['poster']))
{
    execSQL('DELETE FROM `hackathons` WHERE id=?',array($id));
    unlink('../posters/'.htmlentities($_POST['poster']));
    header('location:hackathons.php');
    return;
}
$stmt=execSQL('SELECT * FROM hackathons WHERE id=?',array($id));
$row=$stmt->fetch(PDO::FETCH_ASSOC);
if(empty($row))
{
    $_SESSION['msg']='<p style="font-size:150px">&#128543;</p><div class="alert alert-danger">Contest not found.</div>';
    header('location:dashboard.php');
    return;
}
$t='Delete Hackathon';
require_once "../templates/template2.php";
echo $head;
require_once "../templates/adminnav.php";
?>
<div class="container ct">
    <br>
    <h4>Delete Contest:</h4>
    <img src="../posters/<?php echo $row['poster']; ?>" alt="Hackathon Poster" width="100%"><br><br>
    <dl class="row" style="align-content: left;text-align: left;">
        <dt class="col-md-3">Name:</dt>
        <dd class="col-md-9"><?php echo $row['name'] ?></dd>

        <dt class="col-md-3">Description:</dt>
        <dd class="col-md-9"><?php echo $row['description'] ?></dd>
        
        <dt class="col-md-3">Last Date to Register:</dt>
        <dd class="col-md-9"><?php echo $row['registrationdate'] ?></dd>

        <dt class="col-md-3">Contest Date:</dt>
        <dd class="col-md-9"><?php echo $row['contestdate'] ?></dd>

        <dt class="col-md-3">Participants per Team:</dt>
        <dd class="col-md-9"><?php if($row['min_participants']==$row['max_participants']) echo $row['min_participants'];
            else echo $row['min_participants'].' - '.$row['max_participants']; ?></dd>
    </dl>
    <br>
    Are you sure you want to delete this contest.<br>
    <form method="POST">
        <input type="hidden" name="poster" value="<?php echo $row['poster'] ?>">
        <input type="submit" value="DELETE" class="btn btn-danger">&nbsp;
        <a href="hackathons.php" class="btn btn-secondary">Cancel</a>
    </form>
    <br>
<br>
</div>
<br>
<br>
<br>