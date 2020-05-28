<?php
require_once "../utils.php";
if($_SERVER["REQUEST_METHOD"]== "POST" && isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['repassword']) && !empty($_POST['repassword']) && $_POST['password']==$_POST['repassword'] && isset($_SESSION['email']))
{
    $pwd=hash('md5',$salt1.htmlentities($_POST['password']).$salt2);
    $stmt=execSQL('UPDATE participants SET password=? WHERE email=?',array($pwd,$_SESSION['email']));
    $_SESSION['msg']='<div class="alert alert-success">Password successfully changed.</div><br>';
    unset($_SESSION['email']);
    header('location: login.php');
    return;
}
if(isset($_GET['email']) && isset($_GET['key']) && !empty($_GET['email']) && !empty($_GET['key']))
{
    $email=htmlentities($_GET['email']);
    $key=htmlentities($_GET['key']);
    if($key==hash('md5',$salt1.$email.$salt2))
    {
        $_SESSION['email']=$email;
    }
    else
    {
        header('location: login.php');
    }
}
else
{
    header('location: login.php');
}
$h='<title>Forgot Password</title>';
$f=<<<_END
<script type="text/javascript">
function check() {
    if($('input[name="password"]').val()!=$('input[name="repassword"]').val())
    {
        alert('Password and Retyped Password do not match.');
        return false;
    }
    return true;
}
</script>
_END;
require_once "../templates/template.php";
echo $head;
?>
<div class="container" style="max-width: 500px;">
<br>
<h4>Reset Password:</h4>
<br>
<p>Create a new Pssword.</p>
    <?php msg(); ?>
    <form method="post" action="">
    <div class="form-group">
            <label for="password">Password :</label>
            <input class="form-control" type="password" name="password" placeholder="Your secure password" aria-label="Your secure password" aria-describedby="password" required>
        </div>
        <div class="form-group">
            <label for="repassword">Retype Password :</label>
            <input class="form-control" type="password" name="repassword" placeholder="Retype your password" aria-label="Retype your password" aria-describedby="repassword" required>
        </div>
        <br>
        <input type="submit" name="submit" value="Save" class="btn btn-success" style="align-self:centre;">&nbsp;
        <a href="login.php" class="btn btn-secondary">Back</a>
    </form>
    <br>
</div>
<?php
echo $foot;
?>