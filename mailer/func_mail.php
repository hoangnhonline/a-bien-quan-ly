<?php
include("class.phpmailer.php");
function send_smtp_mail($title,$body,$toaddr)
{
		//return true;
		$mail             = new PHPMailer();
		$body             = $body;
		$body             = eregi_replace("[\]",'',$body);
		
		$mail->IsSMTP();
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
		$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 465;                   // set the SMTP port for the GMAIL server

		$mail->Username   = "vungocdung.info@gmail.com";  // GMAIL username
		$mail->Password   = "Abc123!@#";            // GMAIL password

		$mail->AddReplyTo("vungocdung.info@gmail.com","Vu Ngoc Dung");

		$mail->From       = "vungocdung.info@gmail.com";
		$mail->FromName   = "Vu Ngoc Dung";

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
