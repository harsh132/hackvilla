<?php
require_once "../utils.php";
checklogin('participants');
if(!isset($_GET["id"]) || $_GET["id"]=="")
{
    $_SESSION['msg']='<p style="font-size:150px">&#128543;</p><div class="alert alert-danger">Hackathon not found.</div>';
    header('location:hackathons.php');
    return;
}
$id=htmlentities($_GET['id']);
$stmt=execSQL('SELECT * FROM hackathons WHERE id=?',array($id));
$row=$stmt->fetch(PDO::FETCH_ASSOC);
if($row == false)
{
    $_SESSION['msg']='<p style="font-size:150px">&#128543;</p><div class="alert alert-danger">Hackathon not found.</div>';
    header('location:hackathons.php');
    return;
}
$min=$row['min_participants'];
$max=$row['max_participants'];
$extra=$max-$min;
if($_SERVER["REQUEST_METHOD"]== "POST" && isset($_POST['count']) && $_POST['count']!="" && isset($_POST['name']) && $_POST['name']!="")
{
    $count=htmlentities($_POST['count']);
    if($count<$min-1 || $count>=$max)
    {
        $_SESSION['msg']='<div class="alert alert-danger">ERROR</div>';
    }
    else
    {
        $a=array();
        for($i=1;$i<=$count;$i++)
        {
            if ($_POST['m'.$i]=="")
            {
                $_SESSION['msg']='<div class="alert alert-danger">Please fill all emails.</div>';
                goto out;
            }
            $stmt=execSQL('SELECT id FROM participants WHERE email=?',array($_POST['m'.$i]));
            $id=$stmt->fetchColumn();
            if ($id==false)
            {
                $_SESSION['msg']='<div class="alert alert-danger">Email of member '.$i.' does not exist in our database.</div>';
                goto out;
            }
            array_push($a,$id);
        }
        $stmt=execSQL('INSERT INTO teams VALUES(?,?,?,?,?)',array(null,$_GET['id'],$_POST['name'],$count+1,$_SESSION['user_id']));
        $id=$conn->lastInsertId();
        foreach ($a as $i)
        {
            execSQL('INSERT INTO teammembers (teamid,participantid,hackathonid,status) VALUES(?,?,0)',array($id,$i,htmlentities($_GET['id'])));
        }
        $_SESSION['msg']='<div class="alert alert-success">Successfully Registered.</div>';
        header('location: dashboard.php');

    }
}
if($row['max_participants']==1)
{
    execSQL('INSERT INTO teams (numberofparticipants,leader) VALUES (?,?)',array(1,$_SESSION['user_id']));
    $_SESSION['msg']='<div class="alert alert-success">Successfully Registered.</div>';
    header('location:dashboard.php');
    return;
}
out:
$t="Register for Hackathons - Dashboard";
$h=<<<_END
<script type="text/javascript">
    min=$min;
    function del()
    {
        if(\$('#count').val()>=min)
        {
            \$('#member'+\$('#count').val()).remove();
            \$('#count').val(\$('#count').val()-1)
        }
        return false;
    }
</script>
_END;
require_once "../templates/template2.php";
echo $head;
require_once "../templates/participantnav.php";
?>

<div class="container ct">
<br>
<?php msg(); ?>
<h4>Register for <?php echo $row['name']; ?>:</h4>
<br>
This Hackathon requires a team of <?php if($extra==0)echo $min; else echo $min.' - '.$max; ?> members including Leader.
<br>
<form method="post">
<div class="form-group">
    <label for="name">Name of Team: </label>
    <input type="text" class="form-control" name="name">
</div>
<div class="form-group">
    <input type="hidden" name="count" id="count" value="<?php echo ($max-1); ?>">
    <label for="leader">Leader</label>
    <input id="leader" class="form-control" type="text" name="leader" disabled value="<?php echo $conn->query('SELECT email FROM participants WHERE id='.$_SESSION['user_id'])->fetchColumn() ?>">
</div>
<?php
for($i=1;$i<$max;$i++)
{
    echo <<<_END
    <div class="input-group form-group" id="member$i">
        <label for="m$i">Email of member $i :</label>&nbsp;
        <input id="m$i" class="form-control" type="email" name="m$i" required>
_END;
    if($i>=$min)
    {
        echo '<div class="input-group-append"><button class="btn btn-danger" onclick="return del()">&minus;</button></div>';
    }
    echo '</div>';
}
?>
<input type="submit" value="Register" class="btn btn-success">
</form>
</div>
<br><br>
<?php echo $foot; ?>