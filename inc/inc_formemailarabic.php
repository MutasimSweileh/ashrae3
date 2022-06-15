<?php
$comments ="";
$info_media["code"] = "email";
$contents = $core -> getinfo_media($info_media);
$toemail = $contents[0]["link"];
		$message = "";

if(@$_POST["sendemail"]) {
	$_SESSION["cpost"]=$_POST;
 	$sendemail = $_POST["sendemail"];

	$emailpram = array('email' => $sendemail);
	$core -> addemial($emailpram);
        $message3 = "شكرا علي التسجيل و سيتم تواصل معكم";
}
?>
