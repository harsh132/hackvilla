<?php
require_once "../utils.php";
checklogin('participants');
$t='Dashboard';
require_once "../templates/template2.php";
echo $head;
require_once "../templates/participantnav.php";
?>
<div class="container ct">
<br>
<?php msg(); ?>
<h4>Your Hackathons :</h4>
<br>
<?php
$stmt=execSQL("SELECT id,name,contestdate FROM hackathons WHERE id IN (SELECT hackathonid FROM teams WHERE leader=?) OR (SELECT hackathonid FROM teammembers WHERE participantid=?) and contestdate>NOW()",array($_SESSION['user_id'],$_SESSION['user_id']));
$row=$stmt->fetchAll(PDO::FETCH_ASSOC);
if(count($row)==0)
{
?>
<div class="alert alert-secondary">You are not registered in any hackathons.</div>
<br>
<a href="hackathons.php" class="btn btn-success">Participate Now</a>
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
                <th>Date-Time</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
    <?php
    foreach($row as $r)
    {
        echo '<tr><td>'.$r['name'].'</td><td>'.$r['contestdate'].'</td><td><a href="details.php?id='.$r['id'].'" class="btn btn-primary btn-sm">Details</a> &nbsp; <span class="btn btn-outline-success btn-sm">Registered</span></td></tr>';
    }
    echo '</tbody></table><br>';
}
echo '</div>';
echo $foot;
?>