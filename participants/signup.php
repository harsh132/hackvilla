<?php
require_once "../utils.php";
function signupP()
{
    $var=array('name','email','phone','password','institutetype','institutename','dob','gender');
    $a=array(null);
    
    foreach($var as $v)
    {
        if(!isset($_POST[$v]) || empty($_POST[$v]))
        return $v;
        if($v=='password')
        {
            array_push($a,hash('md5',$GLOBALS['salt1'].$_POST['password'].$GLOBALS['salt2']));
        }
        else
        array_push($a,$_POST[$v]);
    }
    $email=htmlentities($_POST['email']);
    $stmt=execSQL('SELECT status FROM participants WHERE email=?',array($email));
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if ( $row !== false )
    {
        $status=$row['status'];
        if($status==1)
        {
            $_SESSION['msg']='<div class="alert alert-danger">This email already exists in our database please log in.</div><br>';
            header('location: login.php');
            exit(0);
        }
        elseif($status==2)
        {
            $_SESSION['msg']='<div class="alert alert-danger">Your account is blocked by admin.Please contact us on <a href="../contactus.php">Contact Us</a> page.</div><br>';
            header('location: login.php');
            exit(0);
        }
        elseif($status==0)
        {
            $_SESSION['msg']='<div class="alert alert-danger">Your account already exists in our databse but You have not verified your email.Please verify your email.</div><br>';
            header('location: login.php');
            exit(0);
        }
    }
    $key=hash('md5',$GLOBALS['salt1'].$email.$GLOBALS['salt2']);
    array_push($a,0);
    $stmt=execSQL("INSERT INTO participants VALUES(?,?,?,?,?,?,?,?,?,?)",$a);
    sendmail($email,'Confirmation Email : Hakvilla.000webhostapp.com','If You have Signed Up for Hakvilla.000webhostapp.com please verify you account by going to following link:<br><br>
http://hakvilla.000webhostapp.com/organisers/verifyemail.php?email='.$email.'&key='.$key.'

If you haven,t signed up at our site please ignore this email.We wont bother You with any other mail.');
    $stmt=execSQL('SELECT count(*) FROM institutions WHERE name= ?',array(htmlentities($_POST['institutename'])));
    if($stmt->fetchColumn()==0)
    {
        $stmt=execSQL('INSERT INTO institutions (name) VALUES ( ? )',array(htmlentities($_POST['institutename'])));
    }
    return 1;
}
if($_SERVER["REQUEST_METHOD"]== "POST")
{
    $x=signupP();
    if($x==1)
    {
        $_SESSION['msg']='<div class="alert alert-success">You are successfully registerd! Please verify your email to Login.</div><br>';
        header('location: login.php');
    }
    else
    {
        $_SESSION['msg']='<div class="alert alert-danger alert-dismissible fade show">'.$x.' not filled.</div><br>';
    }
}
$h='<title>Participant\'s Sign Up</title>';
$f= <<<_END
<script>
    $('#institutename').autocomplete({source:"institutions.php"});
    
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
    <?php msg(); ?>
    <form method="post" action="">
        <div class="form-group">
            <label for="name">Name :</label>
            <input class="form-control" type="text" name="name" placeholder="Enter your name" aria-label="Enter your name" aria-describedby="name" required>
        </div>
        <div class="form-group">
            <label for="email">Email :</label>
            <input class="form-control" type="email" name="email" placeholder="Enter Your Email" aria-label="Enter Your Email" aria-describedby="email" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone :</label>
            <input class="form-control" type="text" name="phone" placeholder="Enter your phone number" aria-label="Enter your phone number" aria-describedby="phone" required>
            <small class="form-text text-muted">With country code and no dashes ex: +919879879871</small>
        </div>
        <div class="form-group">
            <label for="dob">Date of Birth :</label>
            <input id="dob" class="form-control" type="date" name="dob" required autocomplete="bday">
        </div>
        <div class="form-group">
            <label for="gender">Gender :</label>
            <select name="gender" id="gender" class="browser-default custom-select">
                <option value="m">Male</option>
                <option value="f">Female</option>
                <option value="o">Others</option>
            </select>
        </div>
        <div class="form-group">
            <label for="password">Password :</label>
            <input class="form-control" type="password" name="password" placeholder="Your secure password" aria-label="Your secure password" aria-describedby="password" required>
        </div>
        <div class="form-group">
            <label for="repassword">Retype Password :</label>
            <input class="form-control" type="password" name="repassword" placeholder="Retype your password" aria-label="Retype your password" aria-describedby="repassword" required>
        </div>
        <div class="form-group">
            <label for="institutetype">Select most appropriate :</label>
            <select name="institutetype" id="institutetype" class="browser-default custom-select">
                <option value="school">School</option>
                <option value="college">College/University</option>
                <option value="company">Working for a company or organization</option>
                <option value="self">Self Employed</option>
            </select>
        </div>
        <div class="form-group">
            <label for="institutename">Institute Name :</label>
            <input id="institutename" class="form-control ui-autocomplete-input" type="text" name="institutename" placeholder="Name of your Institute" required autocomplete="off">
            <small class="form-text text-muted">Write Self for self-employed.</small>
        </div>
        <div class="form-check">
            <input id="tos" class="form-check-input" type="checkbox" name="tos" value="false" required>
            <label for="tos" class="form-check-label">By signing up you agree with our <a href="tos.php"> terms and conditions. </a></label>
        </div>
        <br>
        <input type="submit" name="submit" value="submit" class="btn btn-success">
    </form>
    <br>
    <br>
    <br>
</div>
<?php
echo $foot;
?>