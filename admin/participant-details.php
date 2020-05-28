<?php
require_once "../utils.php";
checklogin('admin');
if(!isset($_GET["id"]) || $_GET["id"]=="")
{
    $_SESSION['msg']='<p style="font-size:150px">&#128543;</p><div class="alert alert-danger">Participant not found.</div>';
    header('location:participants.php');
    return;
}
$id=htmlentities($_GET['id']);
$id=htmlentities($_GET['id']);
$stmt=execSQL('SELECT * FROM participants WHERE id=?',array($id));
$row=$stmt->fetch(PDO::FETCH_ASSOC);
if(empty($row))
{
    $_SESSION['msg']='<p style="font-size:150px">&#128543;</p><div class="alert alert-danger">Participant not found.</div>';
    header('location:participants.php');
    return;
}
$t='Participant Details';
require_once "../templates/template2.php";
echo $head;
require_once "../templates/adminnav.php";
?>
<div class="container ct">
    <br>
    <?php msg(); ?>
    <h4>Participant Details :</h4>
    <br>
    <dl class="row" style="align-content: left;text-align: left;">
        <dt class="col-md-3">Id:</dt>
        <dd class="col-md-9"><?php echo $row['id'] ?></dd>

        <dt class="col-md-3">Name:</dt>
        <dd class="col-md-9"><?php echo $row['name'] ?></dd>

        <dt class="col-md-3">Email:</dt>
        <dd class="col-md-9"><?php echo $row['email'] ?></dd>

        <dt class="col-md-3">Mobile:</dt>
        <dd class="col-md-9"><?php echo $row['mobile'] ?></dd>

        <dt class="col-md-3">Institute Type:</dt>
        <dd class="col-md-9"><?php echo $row['institutetype'] ?></dd>

        <dt class="col-md-3">Institute Name:</dt>
        <dd class="col-md-9"><?php echo $row['institutename'] ?></dd>

        <dt class="col-md-3">Gender:</dt>
        <dd class="col-md-9"><?php echo $row['gender'] ?></dd>

        <dt class="col-md-3">D.O.B:</dt>
        <dd class="col-md-9"><?php echo $row['dob'] ?></dd>
    </dl>
    <br>
    <a href="participants.php" class="btn btn-secondary">Back</a>&nbsp;
    <?php
        if($row['status']==2)
        echo '<a href="participant-block.php?id='.$row['id'].'&u=unblock" class="btn btn-success">Unblock</a>';
        else
        echo '<a href="participant-block.php?id='.$row['id'].'" class="btn btn-danger">Block</a>';
    ?>
    <br><br>
</div>
<br>
<br>
<br>
<?php
echo $foot;
?>