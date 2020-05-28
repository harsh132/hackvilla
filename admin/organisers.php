<?php
require_once "../utils.php";
if(!isset($_SESSION['user_id']) || !isset($_SESSION['type']) || $_SESSION['type']!='admin')
{
    header('location:../index.php');
    return;
}
$t="All Organisers - Dashboard";
require_once "../templates/template2.php";
echo $head;
require_once "../templates/adminnav.php";
?>

<div class="container ct">
<br>
<?php msg(); ?>
<h4>All Organisers :</h4>
<br>
<?php
$stmt=$conn->query("SELECT id,name,email,status FROM organisers");
$row=$stmt->fetchAll(PDO::FETCH_ASSOC);
if(count($row)==0)
{
?>
<div class="alert alert-secondary">No Organisers.</div>
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
                <th>E-mail</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    <?php
    foreach($row as $r)
    {
        echo '<tr><td>'.$r['name'].'</td><td>'.$r['email'].'</td><td><a href="org-details.php?id='.$r['id'].'" class="btn btn-primary btn-sm">Details</a> &nbsp; ';
        if($r['status']==2)
        echo '<a href="org-block.php?id='.$r['id'].'&u=unblock" class="btn btn-success btn-sm">Unblock</a>';
        else
        echo '<a href="org-block.php?id='.$r['id'].'" class="btn btn-danger btn-sm">Block</a>';
    }
    echo '</tbody></table><br></div><br><br>';
}

?>

echo $foot;
?>