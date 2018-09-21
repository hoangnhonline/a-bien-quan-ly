<?php
include("class.phpmailer.php");
function send_smtp_mail($title,$body,$toaddr)
{
		return true;
		$mail             = new PHPMailer();
		$body             = $body;
		$body             = eregi_replace("[\]",'',$body);
		
		$mail->IsSMTP();
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
		$mail->Host       = "in-v3.mailjet.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
		//pass mailjet thstore123
		$mail->Username   = "8bf200fdcd40dbe91b5cefb6238fa7d9";  // GMAIL username
		$mail->Password   = "44000b7f2402bc548868502f62c9ee51";            // GMAIL password

		$mail->AddReplyTo("khohang@phanphoibanle.vn","PPBL");

		$mail->From       = "khohang@phanphoibanle.vn";
		$mail->FromName   = "PPBL";

		$mail->CharSet = 'UTF-8';
		$mail->Subject    = $title;
		$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		$mail->WordWrap   = 50; // set word wrap

		$mail->MsgHTML($body);
		
		$explosub = explode(",",$toaddr);
		$mail->AddAddress($explosub[0], $explosub[0]);
		for ($i=1;$i<count($explosub);$i++)
		{
		if (filter_var($explosub[$i], FILTER_VALIDATE_EMAIL))
			{
				$mail->AddCC($explosub[$i]);
			}
		}
		$mail->IsHTML(true); // send as HTML
		if(!$mail->Send()) {
		 return $mail->ErrorInfo;
		} else {
		  return "OK";
		}
}
?>
