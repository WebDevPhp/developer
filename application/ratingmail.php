<?php
    $to = 'karan@ingeniousonline.co.in';
    $subject = 'Marriage Proposal';
    $from = 'pardeep@ingeniousonline.co.in';
    // To send HTML mail, the Content-type header must be set
    $headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    // Create email headers
    $headers .= 'From: '.$from."\r\n".
        'Reply-To: '.  $from."\r\n" .
        'X-Mailer: PHP/' . phpversion();

    // Compose a simple HTML email message
	$message = '<html xmlns="http://www.w3.org/1999/xhtml"><head>  <style type="text/css">
				body {
					padding-top: 0 !important;
					padding-bottom: 0 !important;
					padding-top: 0 !important;
					padding-bottom: 0 !important;
					margin:0 !important;
					width: 100% !important;
					-webkit-text-size-adjust: 100% !important;
					-ms-text-size-adjust: 100% !important;
					-webkit-font-smoothing: antialiased !important;
				}
				.tableContent img {
					border: 0 !important;
					display: block !important;
					outline: none !important;
				}
				a { color:#382F2E; }

				p, h1 {
				  color:#382F2E;
				  margin:0;
				}
				p {
					text-align:left;
					color:#999999;
					font-size:14px;
					font-weight:normal;
					line-height:19px;
				}
				a.link1{
					color:#382F2E;
				}
				a.link2{
					font-size:16px;
					text-decoration:none;
					color:#ffffff;
				}

				h2{
					text-align:left;
					color:#222222; 
					font-size:19px;
					font-weight:normal;
				}
				div,p,ul,h1{
					margin:0;
				}
				.bgItem {
					background-image:url("http://nile.ingeniousonline.co.in/projects/demomailtest/images/bkg1.jpg");
					background-size:cover !important;
					background-repeat:no-repeat !important;
					background-position:center !important;
				}
				</style></head>';
			$message .= '<body style="padding-top: 0; padding-bottom: 0; padding-top: 0; padding-bottom: 0; background-repeat: repeat; width: 100% !important; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; -webkit-font-smoothing: antialiased;" offset="0" toppadding="0" leftpadding="0">';
			$message .= '<table width="600" border="0" cellspacing="0" cellpadding="0" class="tableContent bgBody" align="center"  style="font-family:Helvetica, Arial,serif;">';
			$message .= '<tr><td height="25"></td></tr><tr>';
			$message .= '<td><table width="600" border="0" cellspacing="0" cellpadding="0" align="center" class="bgItem"  style="">';
			$message .= '<tr><td width="40"></td><td width="520"><table width="520" border="0" cellspacing="0" cellpadding="0" align="center"><tr><td height="75"></td></tr><tr>';
            $message .= '<td class="movableContentContainer" valign="top"><div lass="movableContent">';
            $message .= '<table width="520" border="0" cellspacing="0" cellpadding="0" align="center">';
			$message .= '<tr><td valign="top" align="center"><div class="contentEditableContainer contentTextEditable">';
            $message .= '<div class="contentEditable"><p style="text-align:center; margin:0; font-family:Georgia,Time,sans-serif; font-size:26px; color:#222222;"></span></p>';
            $message .= '</div></div></td></tr></table></div>';
			$message .= '<div class="movableContent"><table width="520" border="0" cellspacing="0" cellpadding="0" align="center">';
            $message .= '<tr><td valign="top" align="center"><div class="contentEditableContainer contentImageEditable">';
            $message .= '<div class="contentEditable"><p style="text-align:center; color:#ffffff; font-size:40px; font-family:Verdana, Geneva, sans-serif;font-weight:bold;line-height:35px;">RONDAS</p></div></div></td></tr></table></div>';
			$message .= '<div class="movableContent"><table width="520" border="0" cellspacing="0" cellpadding="0" align="center">';
            $message .= '<tr><td height="55"></td></tr><tr><td height="20"></td></tr><tr><td align="left">';
			$message .= '<div class="contentEditableContainer contentTextEditable"><div class="contentEditable" align="center">
                        <img src="http://nile.ingeniousonline.co.in/projects/demomailtest/images/man.png"></div></div></td></tr>';
			$message .= '<tr><td height="20"></td></tr><tr><td align="left"><div class="contentEditableContainer contentTextEditable">';
            $message .= '<div class="contentEditable" align="center"><p style="text-align:center; color:#ffffff; font-size:28px; font-weight:400; line-height:auto; font-family: "Roboto",sans-serif; letter-spacing:3px;"><br><br><span style="color:#ffffff; font-size:28px; font-weight:bold;">ERNEST </span>Cuentanos come fue <br> <br> tu<span style="color:#ffffff; font-size:28px;font-weight:bold;"> LUNCH </span>con Tennyson Reed </p> </div> </div></td></tr>';
            $message .= '<tr><td height="55"></td></tr><tr><td height="55"></td></tr>';
			$message .= '<tr><td align="center"><table><tr><td align="center" style="padding:0px 10px; height:10px; border:2px solid #ffffff;-webkit-border-radius: 50px; -moz-border-radius: 50px; border-radius: 50px;">';
			$message .= '<div class="contentEditableContainer contentTextEditable"><div class="contentEditable" align="center">';
			$message .= '<a target="_blank" href="#" class="link2" style="padding: 0px;font-family: "Roboto",sans-serif; font-weight:lighter; font-size:20px;color:#ffffff;">RATE YOUR LUNCH</a></div></div></td></tr></table></td></tr>';
            $message .= '<tr><td height="20"></td></tr><tr><td height="75"></td></tr><tr><td height="75"></td></tr>';
			$message .= '<tr><td align="left"><div class="contentEditableContainer contentTextEditable"><div class="contentEditable" align="center"><p style="text-align:center; color:#ffffff; font-size:10px; font-weight:lighter; line-height:30px; font-family: "Roboto",sans-serif; letter-spacing:2px;"> Rondas Corporation © 2015</p></div></div></td></tr></table>';
            $message .= '</div></td></tr></table></td><td width="40"></td></tr></table></td></tr><tr>';
			$message .= '<td height="88"></td></tr></table></body></html>';

		// Sending email

		if(mail($to, $subject, $message, $headers)){

			echo 'Your mail has been sent successfully.';

		} else{

			echo 'Unable to send email. Please try again.';

		}

    ?>

