<?php
require_once "../utils.php";

function signupO()
{
    if(!isset($_FILES['logo'])) return 'Logo not filled.';
    if($_FILES['logo']['size']>400000) return 'File size of logo is too BIG.';
    $ext=strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
    if(!in_array($ext,array("jpeg","jpg","png","svg"))) return "File type not supported";
    $var=array('name','email','phone','password','website','about');
    $a=array(null);
    
    foreach($var as $v)
    {
        if(!isset($_POST[$v]) || empty($_POST[$v]))
        return $v.' not filled.';
        if($v=='password')
        {
            array_push($a,hash('md5',$GLOBALS['salt1'].$_POST['password'].$GLOBALS['salt2']));
        }
        else
        array_push($a,$_POST[$v]);
    }
    $email=htmlentities($_POST['email']);
    $stmt=execSQL('SELECT status FROM organisers WHERE email=?',array($email));
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
    array_push($a,$ext,0);
    $stmt=execSQL("INSERT INTO organisers VALUES(?,?,?,?,?,?,?,?,?)",$a);
    mail($email,'Confirmation Email : Hakvilla.000webhostapp.com','If You have Signed Up for Hakvilla.000webhostapp.com please verify you account by going to following link:<br><br>
http://hakvilla.000webhostapp.com/organisers/verifyemail.php?email='.$email.'&key='.$key.'

If you haven,t signed up at our site please ignore this email.We wont bother You with any other mail.',$headers);
    $id=$GLOBALS['conn']->lastInsertId();
    move_uploaded_file($_FILES['logo']['tmp_name'],"logos/".$id.".".$ext);
    execSQL('UPDATE organisers SET logo=? WHERE id=?',array($id.'.'.$ext,$id));
    return 1;
}

if($_SERVER["REQUEST_METHOD"]== "POST")
{
    $x=signupO();
    if($x==1)
    {
        $_SESSION['msg']='<div class="alert alert-success">You are successfully registerd! Please verify your email by going to verification link sent to your email.</div><br>';
        header('location: login.php');
        exit(0);
    }
    else
    {
        $_SESSION['msg']='<div class="alert alert-danger alert-dismissible fade show">'.$x.'</div><br>';
    }
}
$h='<title>Organiser\'s Sign Up</title>';
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
    <?php msg(); ?>
    <form method="post" action="" enctype="multipart/form-data">
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
            <label for="password">Password :</label>
            <input class="form-control" type="password" name="password" placeholder="Your secure password" aria-label="Your secure password" aria-describedby="password" required>
        </div>
        <div class="form-group">
            <label for="repassword">Retype Password :</label>
            <input class="form-control" type="password" name="repassword" placeholder="Retype your password" aria-label="Retype your password" aria-describedby="repassword" required>
        </div>
        <div class="form-group">
            <label for="website">Website :</label>
            <input id="website" class="form-control" type="text" name="website" placeholder="Your company's website">
        </div>
        <div class="form-group">
            <label for="about">About :</label>
            <textarea name="about" id="about" rows="7" placeholder="About Your organisation" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="logo">Logo :</label>
            <input type="hidden" name="MAX_FILE_SIZE" value="400000">
            <input type="file" name="logo" id="logo" class="form-control-file" accept=".png,.jpg,.jpeg,.svg,image/png,image/jpeg" required>
            <small class="form-text text-muted">Max file size is 300 KB. ( .jpeg .jpg .png .svg )</small>
        </div>
        <div class="form-check">
            <input id="tos" class="form-check-input" type="checkbox" name="tos" value="false" required>
            <label for="tos" class="form-check-label">By signing up you agree with our <a href="tos.php"> terms and conditions. </a></label>
        </div>
        <br>
        <input type="submit" name="submit" value="Sign Up" class="btn btn-success" onclick="return check()">
    </form>
    <br>
</div>
<?php
echo $foot;
?>