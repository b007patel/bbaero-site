<?php 
session_start();

if(!empty($_SESSION['freecap_word_hash']) && !empty($_POST['rcword']))
{
	// all freeCap words are lowercase.
	// font #4 looks uppercase, but trust me, it's not...
	if($_SESSION['hash_func'](strtolower($_POST['rcword']))==$_SESSION['freecap_word_hash'])
	{
		// reset freeCap session vars
		// cannot stress enough how important it is to do this
		// defeats re-use of known image with spoofed session id
		$_SESSION['freecap_attempts'] = 0;
		$_SESSION['freecap_word_hash'] = false;


		// now process form
		$fblink = 'feedback.php';
		$fblinktag = '<a href="'.$fblink.'">feedback.php</a>';

		$to      = 'b007patel@yahoo.com';
		$subject = $_POST['subject'];
		$message = $_POST['comment'];
		$from    = $_POST['email'];
		$headers = 'From: '.$from."\r\n".
		    'Reply-To: '.$from ."\r\n".
		    'X-Mailer: PHP/'.phpversion();

		$mail_sent = mail($to, $subject, $message, $headers);

		if ($mail_sent){ ?>
			<script language="javascript" type="text/javascript">
			alert('Thank you for the message. We will contact you shortly.');
			window.location = '<?php echo $fblink;?>';
			</script>
		<?php } else { ?>
		<script language="javascript" type="text/javascript">
			alert('Message not sent. Please, notify site administrator admin@admin.com');
			window.location = '<?php echo $fblink;?>';
		</script>
<?php
		}


		// now go somewhere else
		// header("Location: somewhere.php");
		$word_ok = "yes";
	} else {
		$word_ok = "no";
		$lwr_rcword = strtolower($_POST['rcword']);
		$sess_lhs = $_SESSION['hash_func']($lwr_rcword)."";
		$sess_rhs = $_SESSION['freecap_word_hash']."";
		$fcword = $_POST['rcword'].'('.$lwr_rcword.')';
	}
} else {
	$word_ok = false;
}
	$page_title = "Bubbly Bubbly Aero - Feedback";

	include $_SERVER["DOCUMENT_ROOT"].'/php/html-start-tmpl.php';

	include $_SERVER["DOCUMENT_ROOT"].'/php/nav-tmpl.php';

	$nl = chr(10);
	$t = chr(9);

	$heading = 'Feedback';
	$lhs_heading = '';
	//$ferr = fopen('phperrs', 'a');
	$dt = new DateTime();
	//fwrite($ferr, $dt->format("Y-M-d, H:i:s").$nl."========".$nl);
	if ($word_ok!==false) {
		if ($word_ok=="yes") {
			//fwrite($ferr, 'for word '.$fcword.' sess lhs == rhs'.$nl);
			$_SESSION['email_result'] = 'Y::Your e-mail has been sent.';
		} else {
			//fwrite($ferr, 'Wrong! trying to set header...'.$nl);
			//fwrite($ferr, 'for word '.$fcword.' sess lhs of if '.$nl);
			//fwrite($ferr, 'is "'.$sess_lhs.'", rhs '.$nl);
			//fwrite($ferr, 'is "'.$sess_rhs.'"'.$nl.$nl);
			$lhs_heading = 'Sorry, the word is wrong, try again.';
			/*echo '<script type="text/javascript">',
				'try {cimg = document.getElementById("captcha_img");', 
				'imgsrc = cimg.src;',
				'imgsrc = imgsrc.substring(0,imgsrc.lastIndexOf(".")+4);',
				'cimg.src = imgsrc + "?" + Math.round(Math.random()*100000);}',
				'catch(e) {console.log("Whoops! no captcha img!");}',
				'</script>';*/
			echo '<script type="text/javascript">',
				'try {new_freecap();}',
				'catch(e) {console.log("Whoops! no captcha img!");}',
				'</script>';
		}
	} else {
		//fwrite($ferr, "In else file(s) exists branch..".$nl);
	}
	//fwrite($ferr, "lhs head len ".strlen($lhs_heading).$nl);
	//fwrite($ferr, "is email_res empty? ".(empty($_SESSION['email_result'])?'yes':'no')."--".$nl);
	if (strlen($lhs_heading) < 1 && !empty($_SESSION['email_result'])) {
		if (substr($_SESSION['email_result'], 0, 3) == 'N::') {
			$lhs_heading = substr($_SESSION['email_result'], 3);
			//fwrite($ferr, 'Found N::, lhs_heading is now '.$lhs_heading.$nl);
			//fwrite($ferr, 'unset after setting lhs head to email sent'.$nl);
			unset($_SESSION['email_result']);
		}
	}
	//fclose($ferr);
	$rhs_heading = '';
	$lhs_html = str_repeat(chr(9), 6).'<div id="formdiv">'.$nl;
	$lhs_html .= str_repeat(chr(9), 7).'<form id="feedbackform" action="'.$_SERVER['PHP_SELF'].'" method="post">'.$nl;
	$lhs_html .= <<<'EOD'
						<ul class="fbfieldlist">
							<li><label>Your e-mail:</label></li><li><input id="fbemail" name="email" class="fbfield" form="feedbackform"></input></li>
						</ul>
						<ul class="fbfieldlist">
							<li><label>Subject:</label></li><li><input id="fbsubject" name="subject" class="fbfield" form="feedbackform"></input></li>
						</ul>
						<ul id="fbtextlist">
							<li><label id="commentslabel">Comments:</label></li>
							<li><textarea id="fbtext" name="comment" form="feedbackform"></textarea></li>
							<li><img style="display:none;" src="freecap.php" id="freecap"></img></li>
							<li><img src="cpimg.png" id="captcha_img"></img></li>
							<li>If you can't read the word, <a href="#" onClick="this.blur();new_freecap();return false;">click here</a></li>
							<li>Word above:<input type="text" name="rcword"></input></li>
							<li><input type="submit" value="Send comment"></input></li>
						</ul>
						</form>
						</div>

EOD;
	$rhs_html = <<<'EOD'


EOD;

	$bottom_html = <<<'EOD'

EOD;

	include $_SERVER["DOCUMENT_ROOT"].'/php/main-tmpl.php';
	
	//$ferr = fopen('phperrs', 'a');
	//fwrite($ferr, "Is lhs head empty? '".$lhs_heading."'".$nl);
	if (!empty($_SESSION['email_result'])) {
		//fwrite($ferr, $t."email_res is ".$_SESSION['email_result'].$nl);
		if (substr($_SESSION['email_result'], 0, 3) == 'Y::') {
			//fwrite($ferr, $t."email_res starts with Y::".$nl);
			$_SESSION['email_result'][0] = 'N';
			//fwrite($ferr, $t.">> new email_res is ".$_SESSION['email_result'].$nl);
		}
	}
	//fwrite($ferr, "=====end=====".$nl.$nl);
	//fclose($ferr);
	include $_SERVER["DOCUMENT_ROOT"].'/php/footer-tmpl.php'; 
	
	include $_SERVER["DOCUMENT_ROOT"].'/php/html-end-tmpl.php';
