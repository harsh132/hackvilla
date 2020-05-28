<?php
require_once "../utils.php";
if(!isset($_SESSION['user_id']) || !isset($_SESSION['type']) || $_SESSION['type']!='admin')
{
    header('location:../index.php');
    return;
}
$t="All Hackathons - Dashboard";
require_once "../templates/template2.php";
echo $head;
require_once "../templates/adminnav.php";
?>

<div class="container ct">
<br>
<?php msg(); ?>
<h4>All Hackathons :</h4>
<br>
<?php
$stmt=$conn->query("SELECT hackathons.id,hackathons.name AS hname,hackathons.contestdate,organisers.name AS oname,hackathons.status FROM hackathons INNER JOIN organisers ON hackathons.organiser_id=organisers.id ORDER BY hackathons.status");
$row=$stmt->fetchAll(PDO::FETCH_ASSOC);
if(count($row)==0)
{
?>
<div class="alert alert-secondary">No Hackathons.</div>
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
                <th>Organiser</th>
                <th>Date-Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    <?php
    foreach($row as $r)
    {
        echo '<tr><td>'.$r['hname'].'</td><td>'.$r['oname'].'</td><td>'.$r['contestdate'].'</td><td><a href="details.php?id='.$r['id'].'" class="btn btn-primary btn-sm">Details</a> &nbsp; <a href="delete.php?id='.$r['id'].'" class="btn btn-danger btn-sm">Delete</a>';
        if($r['status']==0) echo ' &nbsp; <a href="approve.php?id='.$r['id'].'" class="btn btn-success btn-sm">Approve</a>';
        echo '</td></tr>';
    }
    echo '</tbody></table><br></div><br><br>';
}

?>

echo $foot;
?>