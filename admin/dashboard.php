<?php
require_once "../utils.php";
checklogin('admin');
$t='Dashboard';
require_once "../templates/template2.php";
echo $head;
require_once "../templates/adminnav.php";
?>
<div class="container ct">
<br>
<?php msg(); ?>
<h4>New Contests :</h4>
<br>
<?php
$stmt=$conn->query("SELECT hackathons.id,hackathons.name AS hname,hackathons.contestdate,organisers.name AS oname FROM hackathons INNER JOIN organisers ON hackathons.organiser_id=organisers.id WHERE hackathons.status=0");
$row=$stmt->fetchAll(PDO::FETCH_ASSOC);
if(count($row)==0)
{
?>
<div class="alert alert-secondary">No New Contest.</div>
<br>
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
        echo '<tr><td>'.$r['hname'].'</td><td>'.$r['oname'].'</td><td>'.$r['contestdate'].'</td><td><a href="details.php?id='.$r['id'].'" class="btn btn-primary btn-sm">Details</a> &nbsp; <a href="delete.php?id='.$r['id'].'" class="btn btn-danger btn-sm">Delete</a> &nbsp; <a href="approve.php?id='.$r['id'].'" class="btn btn-success btn-sm">Approve</a></td></tr>';
    }
    echo '</tbody></table><br></div><br><br>';
}
echo $foot;
?>