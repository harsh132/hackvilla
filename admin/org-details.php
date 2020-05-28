<?php
require_once "../utils.php";
checklogin('admin');
if(!isset($_GET["id"]) || $_GET["id"]=="")
{
    $_SESSION['msg']='<p style="font-size:150px">&#128543;</p><div class="alert alert-danger">Organiser not found.</div>';
    header('location:organisers.php');
    return;
}
$id=htmlentities($_GET['id']);
$stmt=execSQL('SELECT * FROM organisers WHERE id=?',array($id));
$row=$stmt->fetch(PDO::FETCH_ASSOC);
if(empty($row))
{
    $_SESSION['msg']='<p style="font-size:150px">&#128543;</p><div class="alert alert-danger">Organiser not found.</div>';
    header('location:organisers.php');
    return;
}
$t='Organiser Details';
require_once "../templates/template2.php";
echo $head;
require_once "../templates/adminnav.php";
?>
<div class="container ct">
    <br>
    <?php msg(); ?>
    <h4>Organiser Details :</h4>
    <br>
    <img src="../organisers/logos/<?php echo $row['logo']; ?>" alt="logo">
    <dl class="row" style="align-content: left;text-align: left;">
        <dt class="col-md-3">Id:</dt>
        <dd class="col-md-9"><?php echo $row['id'] ?></dd>

        <dt class="col-md-3">Name:</dt>
        <dd class="col-md-9"><?php echo $row['name'] ?></dd>

        <dt class="col-md-3">Email:</dt>
        <dd class="col-md-9"><?php echo $row['email'] ?></dd>

        <dt class="col-md-3">Phone:</dt>
        <dd class="col-md-9"><?php echo $row['phone'] ?></dd>

        <dt class="col-md-3">Website:</dt>
        <dd class="col-md-9"><?php echo $row['website'] ?></dd>

        <dt class="col-md-3">About:</dt>
        <dd class="col-md-9"><?php echo $row['about'] ?></dd>
    </dl>
    <br>
    <a href="organisers.php" class="btn btn-secondary">Back</a>&nbsp;
    <?php
        if($row['status']==2)
        echo '<a href="organiser-block.php?id='.$row['id'].'&u=unblock" class="btn btn-success">Unblock</a>';
        else
        echo '<a href="organiser-block.php?id='.$row['id'].'" class="btn btn-danger">Block</a>';
    ?>
    <br><br>
</div>
<br>
<br>
<br>
<?php
echo $foot;
?>