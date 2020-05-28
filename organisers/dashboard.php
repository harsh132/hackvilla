<?php
require_once "../utils.php";
if(!isset($_SESSION['user_id']) || !isset($_SESSION['type']) || $_SESSION['type']!='organisers')
{
    header('location:../index.php');
    return;
}
$t="Dashboard";
require_once "../templates/template2.php";
echo $head;
require_once "../templates/organisernav.php";
?>

<div class="container ct">
<br>
<?php msg(); ?>
<h4>Ongoing Contests :</h4>
<br>
<?php
$stmt=execSQL("SELECT id,name,contestdate FROM hackathons WHERE organiser_id=? and contestdate>NOW()",array($_SESSION['user_id']));
$row=$stmt->fetchAll(PDO::FETCH_ASSOC);
if(count($row)==0)
{
?>
<div class="alert alert-secondary">No Active Contest.</div>
<br><br>
<?php
}
else
{
    ?>
    <table class="table table-light table-hover">
        <thead class="thead-dark">
            <tr>
                <th style="min-width: 50%;">Name</th>
                <th>Date-Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    <?php
    foreach($row as $r)
    {
        echo '<tr><td>'.$r['name'].'</td><td>'.$r['contestdate'].'</td><td><a href="details.php?id='.$r['id'].'" class="btn btn-primary btn-sm">Details</a> &nbsp; <a href="edit.php?id='.$r['id'].'" class="btn btn-warning btn-sm">Edit</a> &nbsp; <a href="delete.php?id='.$r['id'].'" class="btn btn-danger btn-sm">Delete</a></td>';
    }
    echo '</tbody></table><br>';
}

?>
<h4>Past Contests :</h4>
<br>
<?php
$stmt=execSQL("SELECT id,name,contestdate FROM hackathons WHERE organiser_id=? and contestdate<=NOW()",array($_SESSION['user_id']));
$row=$stmt->fetchAll(PDO::FETCH_ASSOC);
if(count($row)==0)
{
?>
<div class="alert alert-secondary">No Past Contest.</div>
<br><br>
<?php
}
else
{
    ?>
    <table class="table table-light">
        <thead class="thead-dark">
            <tr>
                <th style="min-width: 50%;">Name</th>
                <th>Date-Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    <?php
    foreach($row as $r)
    {
        echo '<tr><td>'.$r['name'].'</td><td>'.$r['contestdate'].'</td><td><a href="details.php?id='.$r['id'].'" class="btn btn-primary btn-sm">Details</a></td></tr>';
    }
    echo '</tbody></table></div><br><br>';
}
echo $foot;
?>