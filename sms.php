<!DOCTYPE html>
<html>
<head>
	<title>VENKATA SAI | SMS GATEWAY</title>
</head>
<body bgcolor="">
<style type="text/css">
	input{
		border-radius: 5px;
		border:1px solid grey;
		padding: 10px;
		font-weight: bold;
		margin: 10px;
	}
</style>
<CENTER>
<h1>Way2sms Gateway</h1>
	<form method="post" action="sms.php">
	<input type="text" name="un" placeholder="way2sms username"><br>
	<input type="text" name="pwd" placeholder="way2sms password"><br>
	<input type="text" name="to" placeholder="recepient number"><br>
	<input type="textarea" cols=6  rows=6 name="msg" placeholder="message"><br>
		<input type="submit" name="" value="send">
	</form>
	
</CENTER>
<p align="right"><b>BY :VENKATA SAI KATEPALLI</b></p>
</body>
</html>























<?php
if(isset($_POST['to']))
{
	$to=$_POST['to'];
	$msg=$_POST['msg'];
	$uid=$_POST['un'];
	$pwd=$_POST['pwd'];

	include('func.php');
error_reporting(0);
$ser="http://site24.way2sms.com/";
$ckfile = tempnam ("/tmp", "CURLCOOKIE");
$login=$ser."Login1.action";
//$msg=input($_GET['msg']);
if(!$to)
{ $to=$uid; }
if(!$msg)
{ $msg=rword(5).rword(5).rword(5).rword(5).rword(5); }
$captcha=input($_REQUEST['captcha']);
flush();
if($uid && $pwd)
{
$ibal="0";
$sbal="0";
$lhtml="0";
$shtml="0";
$khtml="0";
$qhtml="0";
$fhtml="0";
$te="0";
//echo '<div class="content">User: <span class="number"><b>'.$uid.'</b></span><br>';
flush();

$loginpost="gval=&username=".$uid."&password=".$pwd."&Login=Login";

$ch = curl_init();
$lhtml=post($login,$loginpost,$ch,$ckfile);
////curl_close($ch);

if(stristr($lhtml,'Location: '.$ser.'vem.action') || stristr($lhtml,'Location: '.$ser.'MainView.action') || stristr($lhtml,'Location: '.$ser.'ebrdg.action'))
{
preg_match("/~(.*?);/i",$lhtml,$id);
$id=$id['1'];
if(!$id)
{
goto end;
}
// * Login Sucess Message//
goto bal;
}
elseif(stristr($lhtml,'Location: http://site2.way2sms.com/entry'))
{
// * Login Faild or SMS Send Error Message 3//
	?>
	<script>alert("failed on sending SMS!!!");</script>
	<?php
goto end;
}
else
{
	?>
	<script>alert("failed on sending SMS!!!");</script>
	<?php
goto end;
}
bal:
$msg=urlencode($msg);
$main=$ser."smstoss.action";
$ref=$ser."sendSMS?Token=".$id;
$conf=$ser."smscofirm.action?SentMessage=".$msg."&Token=".$id."&status=0";

$post="ssaction=ss&Token=".$id."&mobile=".$to."&message=".$msg."&Send=Send Sms&msgLen=".strlen($msg);
$mhtml=post($main,$post,$ch,$ckfile,$proxy,$ref);
if(stristr($mhtml,'smscofirm.action?SentMessage='))
// * Message Sended Sucessfull Message//
{
	//echo "otp sent to your mobile";
	?>
	<script>alert("SMS Sended Sucessfully!!!");</script>
	<?php
}
else
// * Login Faild or SMS Send Error Message 1//
{ // onclick="this.parentElement.style.display="none"" class="w3-closebtn">&times;</span>
?>
	<script>alert("Login failed!!!");</script>
	<?php
}
curl_close($ch);

end:

//echo "</div>";
flush();
}}
else
{

}?>
