<?php
require_once "../utils.php";
$t="Hackathon Details";
require_once "../templates/template2.php";
echo $head;
require_once "../templates/organisernav.php";
?>
<div class="container ct">
    <?php
    if(!isset($_GET["id"]) || $_GET["id"]=="")
    {
        echo '<p style="font-size:150px">&#128543;</p><div class="alert alert-danger">Contest not found.</div></div>';
        echo $foot;
        exit(0);
    }
    $id=htmlentities($_GET['id']);
    $stmt=execSQL('SELECT * FROM hackathons WHERE id=?',array($id));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    $org= $conn->query('SELECT name,email,logo,website,about FROM organisers WHERE id='.$row['organiser_id'])->fetch(PDO::FETCH_ASSOC);
    if(empty($row))
    {
        echo '<p style="font-size:150px">&#128543;</p><div class="alert alert-danger">Contest not found.</div></div>';
        echo $foot;
        exit(0);
    }
    ?>
    <br>
    <h4><?php echo $row['name']; ?></h4>
    <img src="../posters/<?php echo $row['poster']; ?>" alt="Hackathon Poster" width="100%"><br><br>
    <dl class="row" style="align-content: left;text-align: left;">
        <dt class="col-md-3">Organised By:</dt>
        <dd class="col-md-9"> <a href="" data-toggle="modal" data-target="#orgdetails" onclick="return false"> <?php echo $org['name']; ?></a> </dd>
        <div class="modal fade" id="orgdetails" tabindex="-1" role="dialog" aria-labelledby="orgdetailsLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="orgdetailsLabel"><?php echo $org['name']; ?></h5>
                </div>
                <div class="modal-body">
                  <img src="logos/<?php echo $org['logo']; ?>" alt="<?php echo $org['name']; ?>'s Logo" width="100%"><br><br>
                  <?php echo $org['about']; ?><br><br>
                  Email: <?php echo $org['email']; ?>
                </div>
                <div class="modal-footer" style="justify-content: center;">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

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
    <a href="dashboard.php" class="btn btn-secondary">Back</a>
    <?php
    if($row['contestdate']>date("Y-m-d h:i:s"))
    {
      echo '&nbsp;<a href="edit.php?id='.$id.'" class="btn btn-warning">Edit</a>';
    }
    ?>
    <br><br>
<br>
</div>
<br>
<br>
<br>