<?php

$logi = new Tweak( 'login_log' );
$logi->addTweak( 'login-head', 'login_log' );
$logi->addTweak( 'after-logged-in', 'login_log' ); 
$logi->Author('Jens-Erik Vesterbaek, www.jeweb.dk');
$logi->Description( 'Log Admin logins' );

function login_log()   
{

?>
<?php
if ( $_SERVER["REQUEST_METHOD"]=="POST" ) {

unset($_POST["submit"]);
$data = implode('|', $_POST);
$time = date ("h:i A");
$date = date ("l, F jS, Y");
$ip = $_SERVER['REMOTE_ADDR'];
$value = "$data | $time | $date | $ip";
if (get_magic_quotes_gpc()) {
$data = stripslashes($data);
}
$listf = fopen ("tweaks/login_log/logfile.txt", "a+"); 
fwrite($listf, "$value\n");
fclose($listf);
}
?>

<?php
}
?>
