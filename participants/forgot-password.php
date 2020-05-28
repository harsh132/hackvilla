<?php
require_once "../utils.php";
if($_SERVER["REQUEST_METHOD"]== "POST" && isset($_POST['email']) && !empty($_POST['email']))
{
    $email=htmlentities($_POST['email']);
    $stmt=execSQL('SELECT Count(*) FROM participants WHERE email=?',array($email));
    if($stmt->fetchColumn() >0)
    {
        $key=hash('md5',$salt1.$email.$salt2);
        mail(htmlentities($_POST['email']),'Reset Password : HakVilla.000webhostapp.com','Password Reset Link :
        http://hakvilla.000webhostapp.com/participants/reset-password.php?email='.$email.'&key='.$key,$headers);
        $_SESSION['msg']='<div class="alert alert-success">Password Reset Email sent.</div><br>';
    }
    else
    $_SESSION['msg']='<div class="alert alert-danger">Email doesn\'t exists our database, Please Sign Up .</div><br>';
}
$h='<title>Forgot Password</title>';
require_once "../templates/template.php";
echo $head;
?>
<div class="container" style="max-width: 500px;">
<br>
<h4>Forgot Password:</h4>
<br>
<p>We will send you an email with a password reset link.</p>
    <?php msg(); ?>
    <form method="post" action="">
        <div class="form-group">
            <label for="email">Email :</label>
            <input class="form-control" type="email" name="email" placeholder="Enter Your Email" aria-label="Enter Your Email" aria-describedby="email" required>
        </div>
        <br>
        <input type="submit" name="submit" value="Send Mail" class="btn btn-success" style="align-self:centre;">&nbsp;
        <a href="login.php" class="btn btn-secondary">Back</a>
    </form>
    <br>
</div>
<?php
echo $foot;
?>