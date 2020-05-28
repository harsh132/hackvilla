<?php
require_once "../utils.php";
if($_SERVER["REQUEST_METHOD"]== "POST" && isset($_POST['email']) && isset($_POST['password']) && !empty($_POST['email']) && !empty($_POST['password']))
{
    $x=login('organisers',$_POST['email'],$_POST['password']);
    if($x!==true)
    {
        $_SESSION['msg']=$x;
    }
    else
    {
        header('location:dashboard.php');
    }
}
$h='<title>Organiser\'s Sign In</title>';
require_once "../templates/template.php";
echo $head;
?>
<div class="container" style="max-width: 500px;">
<br>
<h4>Login:</h4>
<br>
    <?php msg(); ?>
    <form method="post" action="">
        <div class="form-group">
            <label for="email">Email :</label>
            <input class="form-control" type="email" name="email" placeholder="Enter Your Email" aria-label="Enter Your Email" aria-describedby="email" required>
        </div>
        <div class="form-group">
            <label for="password">Password :</label>
            <input class="form-control" type="password" name="password" placeholder="Your secure password" aria-label="Your secure password" aria-describedby="password" required>
        </div>
        <div class="form-check">
            <input id="remember" class="form-check-input" type="checkbox" name="remember" value="false">
            <label for="remember" class="form-check-label">Remember me on this device.</label>
        </div>
        <br>
        <input type="submit" name="submit" value="Log In" class="btn btn-success" style="align-self:centre;">
    </form>
    <br>
    <a href="forgot-password.php">Forgot Password</a><br>
    <a href="signup.php">Don't have an account? Sign Up</a>
    <br>
</div>
<?php
echo $foot;
?>