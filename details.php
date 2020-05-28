<?php
require_once "utils.php";
if(!isset($_GET["id"]) || $_GET["id"]=="")
{
    $_SESSION['msg']='<p style="font-size:150px">&#128543;</p><div class="alert alert-danger">Hackathon not found.</div>';
    header('location:hackathons.php');
    return;
}
$id=htmlentities($_GET['id']);
$stmt=execSQL('SELECT * FROM hackathons WHERE id=?',array($id));
$row=$stmt->fetch(PDO::FETCH_ASSOC);
$org= $conn->query('SELECT name,email,logo,website,about FROM organisers WHERE id='.$row['organiser_id'])->fetch(PDO::FETCH_ASSOC);
if(empty($row))
{
    $_SESSION['msg']='<p style="font-size:150px">&#128543;</p><div class="alert alert-danger">Hackathon not found.</div>';
    header('location:hackathons.php');
    return;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>

<link rel="stylesheet" href="templates/inc/style2.css">
<title>Hackathon details | Hackcovid.com</title>
</head>
<body>
  <br>
<div class="container ct">
    <br>
    <h4><?php echo $row['name']; ?></h4>
    <img src="posters/<?php echo $row['poster']; ?>" alt="Hackathon Poster" width="100%"><br><br>
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
                  <img src="../organisers/logos/<?php echo $org['logo']; ?>" alt="<?php echo $org['name']; ?>'s Logo" width="100%"><br><br>
                  <?php echo $org['about']; ?><br><br>
                  Email: <?php echo $org['email']; ?>
                </div>
                <div class="modal-footer" style="justify-content: center;">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <a href="org-details.php?id=<?php echo $row['organiser_id']; ?>" class="btn btn-primary">Details</a>
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
    <a href="index.php" class="btn btn-secondary">Back</a>&nbsp;
    <br><br>
<br>
</div>
<br>
<br>
<br>
</body>
</html>