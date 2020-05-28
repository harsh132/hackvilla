<?php
require_once "../utils.php";
if(!isset($_SESSION['user_id']) || !isset($_SESSION['type']) || $_SESSION['type']!='organisers')
{
    header('location:login.php');
    return;
}
if(!isset($_GET["id"]) || $_GET["id"]=="")
{
    $_SESSION['msg']='<p style="font-size:150px">&#128543;</p><div class="alert alert-danger">Contest not found.</div>';
    header('location:dashboard.php');
    return;
}
$id=htmlentities($_GET['id']);
$stmt=execSQL('SELECT * FROM hackathons WHERE id=? AND contestdate>NOW() AND organiser_id=?',array($id,$_SESSION['user_id']));
$row=$stmt->fetch(PDO::FETCH_ASSOC);
if(empty($row))
{
    $_SESSION['msg']='<p style="font-size:150px">&#128543;</p><div class="alert alert-danger">Contest not found.</div>';
    header('location:dashboard.php');
    return;
}
function edithackathon($row)
{
    $ext=$row['poster'];
    if(isset($_FILES['poster']['name']) && !empty($_FILES['poster']['name']))
    {
        if($_FILES['poster']['size']>1100000) return 'File size of poster is too BIG.';
        $ext=strtolower(pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION));
        if(!in_array($ext,array("jpeg","jpg","png","svg"))) return "File type not supported";
        $ext=$row['id'].'.'.$ext;
    }
    $var=array('name','description','registrationdate','contestdate','min-participants','max-participants');
    $a=array();
    foreach($var as $v)
    {
        if(!isset($_POST[$v]) || empty($_POST[$v]))
        return $v.' not filled.';
        array_push($a,$_POST[$v]);
    }
    array_push($a,$ext,$row['id']);
    $stmt=execSQL('UPDATE hackathons SET `name`=?,`description`=?,`registrationdate`=?,`contestdate`=?,`min_participants`=?,`max_participants`=?,`poster`=? WHERE `id`=?',$a);
    move_uploaded_file($_FILES['poster']['tmp_name'],"../posters/".$ext);
    return 1;
}
if($_SERVER["REQUEST_METHOD"]== "POST")
{
    $x=edithackathon($row);
    if($x==1)
    {
        $_SESSION['msg']='<div class="alert alert-success alert-dismissible fade show">Hackcathon is successfully edited.</div><br>';
        header('location: dashboard.php');
        exit(0);
    }
    else
    {
        $_SESSION['msg']='<div class="alert alert-danger alert-dismissible fade show">'.$x.'</div><br>';
    }
}
$t='Edit Contest';
require_once "../templates/template2.php";
echo $head;
require_once "../templates/organisernav.php";
?>
<div class="container ct">
<div class="container" style="max-width: 500px;">
    <br>
    <h3>Edit Contest</h3>
    <?php msg(); ?>
    <form method="post" action="" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name :</label>
            <input class="form-control" type="text" name="name" placeholder="Name of Contest" aria-label="Name of Contest" aria-describedby="name" required value="<?php echo $row['name']; ?>">
        </div>
        <div class="form-group">
            <label for="desciption">Description :</label>
            <textarea name="description" id="description" rows="7" placeholder="Description of Contest" class="form-control" required><?php echo $row['description']; ?></textarea>
        </div>
        <div class="form-group">
            <label for="contestdate">Date of Contest :</label>
            <input class="form-control" type="datetime-local" name="contestdate" id="contestdate" aria-label="Date of Contest" aria-describedby="contestdate" min="<?php echo date("Y-m-d")."T".date("H:i"); ?>" required value="<?php echo $row['contestdate']; ?>">
        </div>
        <div class="form-group">
            <label for="registrationdate">Last Date to Register :</label>
            <input class="form-control" type="datetime-local" name="registrationdate" id="registrationdate" aria-label="Last Date to Register" aria-describedby="registrationdate" min="<?php echo date("Y-m-d")."T".date("H:i"); ?>" required value="<?php echo $row['registrationdate']; ?>">
        </div>
        <div class="form-group">
            <label for="min-participants">Minimum Number of Participants :</label>
            <input id="min-participants" class="form-control" type="number" name="min-participants" value="<?php echo $row['min_participants']; ?>">
        </div>
        <div class="form-group">
            <label for="max-parcipants">Maximum number of parcipants :</label>
            <input id="max-parcipants" class="form-control" type="number" name="max-participants" value="<?php echo $row['max_participants']; ?>">
        </div>
        <div class="form-group">
            <label for="poster">Poster :</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="1100000">
            <input type="file" name="poster" id="poster" class="form-control-file" accept=".png,.jpg,.jpeg,.svg,image/*">
            <small class="form-text text-muted">Max file size is 1 MB. ( .jpeg .jpg .png .svg ).<br>If you want to replace the old poster, upload a new one.</small>
        </div>
        <br>
        <input type="submit" name="submit" value="Save Changes" class="btn btn-success">
        <a href="dashboard.php" class="btn btn-light">Cancel</a>
    </form>
    <br>
</div>
</div>
<br>
<br>
<br>
<?php
echo $foot;
?>