<?php
require_once "../utils.php";
$email="prakashharsh32@gmail.com";
$key="emailkeyasdfghjklqwertyuiopzxcvbnmqazwsxedcrfvtgbyhn";
mail($email,'Confirmation Email : Hakvilla.000webhostapp.com','If You have Signed Up for Hakvilla.000webhostapp.com please verify you account by going to following link:
http://hakvilla.000webhostapp.com/organisers/verifyemail.php?email='.$email.'&key='.$key.'
If you haven,t signed up at our site please ignore this email.We wont bother You with any other mail.',$headers);
echo 'done{$email}';
?>