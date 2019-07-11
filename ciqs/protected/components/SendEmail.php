<?php
	class SendEmail{
		
		public function mailsend($to,$from,$subject,$message){
			$mail=Yii::app()->Smtpmail;
			$mail->SetFrom($from, 'CIQS Application');
			$mail->Subject = $subject;
			$mail->MsgHTML($message);
			$mail->AddAddress($to, "");
			if(!$mail->Send()) {
				echo "Mailer Error: " . $mail->ErrorInfo;
			}else {
				//echo "Message sent!";
			}
		}
	}
?>