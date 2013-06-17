<?php
	/*
	* This is a simple contact form that use mail() function.
	* @copyright GarfieldFr, modified by yoit
	* @license GPL
	*/
	$nc_contact = new Tweak('Contact Form');
	$nc_contact->Author('yoit');
	//$nc_contact->Version('0.4');
	//$nc_contact->Icon('nc_contact.png');
	$nc_contact->Description('Contact form using standard mail() function.');
	$nc_contact->addTweak('contact_form', 'display_contact_form');
	$nc_contact->addInterface('nc_contact_config');
	
	define('NANO_CONFIG_DIR', NANO_AREAS_DIR.'config/');
	
	function validateAddress($email) {
		// script from http://www.ilovejackdaniels.com/php/email-address-validation/
		// First, we check that there's one @ symbol, and that the lengths are right
		if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
			// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
			return false;
		}
		
		// Split it into sections to make life easier
		$email_array=explode("@", $email);
		$local_array=explode(".", $email_array[0]);
		
		for ($i = 0; $i < sizeof($local_array); $i++) {
			if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$",
			$local_array[$i])) {
				return false;
			}
		}
		
		if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
			$domain_array=explode(".", $email_array[1]);
			
			if (sizeof($domain_array) < 2) {
				return false; // Not enough parts to domain
			}
			
			for ($i = 0; $i < sizeof($domain_array); $i++) {
				if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
					return false;
				}
			}
		}
		
		return true;
	}
	
	function display_contact_form() {
		if (!isset($cf_errors))
			$cf_errors = array();
		if (isset($_POST['cf_action']) && ($_POST['cf_action'] == 'sending')) {
			$mail = $_POST['mail'];
			
			if (empty($mail['name']))
				$cf_errors[] = lt("Enter your name");
			else
				$mail['name'] = htmlentities(stripslashes(urldecode($mail['name'])));
			
			if (empty($mail['from']))
				$cf_errors[] = lt("Enter your email");
			else {
				if (!validateAddress($mail['from']))
					$cf_errors[] = lt("Enter a valid email");
			}
			
			if (empty($mail['subject']))
				$cf_errors[] = lt("Enter a subject");
			else
				$mail['subject'] = htmlentities(stripslashes(urldecode($mail['subject'])));
			
			if (empty($mail['body']))
				$cf_errors[] = lt("Enter a message");
			else
				$mail['body'] = htmlentities(stripslashes(urldecode($mail['body'])),ENT_QUOTES, "UTF-8");

			if ($mail['check'] != 'yellow')
				$cf_errors[] = lt("Enter the red word");
			
			if (count($cf_errors) == 0) {
				// load config
				$config_file = NANO_CONFIG_DIR.'nc_contact.dat';
				$nc_config = file($config_file);
				
				//try to send mail
				$header  = "From: ".$mail['name']." <".$mail['from'].">\r\n";
				//$header .= "BCC: ".$nc_config[1]." <".$nc_config[0].">\r\n";
				$header .= "Content-type: text/text; charset=utf-8\r\n";
				
				$body  = $mail['subject']."\r\n";;
				$body .= "------------------------------------------------\r\n";
				$body .= "\r\n";
				$body .= $mail['body'];
				$body .= "\r\n\r\n";
				//$body .= "_________________________________________\r\n";
				$body .= "------------------------------------------------\r\n";
				$body .= date("D, d M Y")." - ".$_SERVER["SERVER_NAME"]." (".$_SERVER["SERVER_ADDR"].")";
				
				$subject = $nc_config[2].$mail['subject'];
				
				if (!mail($nc_config[0], $subject, $body, $header))
					$cf_errors[] = lt("Error when sending email");
				else {
					if (count($cf_errors) == 0) {
						echo '<div class="msgbox greenbox">'.lt("Your mail is on it's way...")."</div>\n";
					}
				}
			}
		}
		
		echo '
		<form method="post" action="index.php?',NANO_SLUGWORD,'=',$_GET[NANO_SLUGWORD],'" name="mail[]">
		   <input type="hidden" name="cf_action" value="sending" />
		 ';
		if (count($cf_errors) > 0) {
			echo '<div class="msgbox redbox"><ul>';
			foreach($cf_errors as $k => $error){
				echo '<li>'.$error."</li>\n";
			}
			echo "</ul></div>\n";
		}
		echo '
			<table font size="2" span style="font-family: Arial" padding-left="40px">
				<tr>
					<td>',lt('Your Name'),': </td>
					<td><input type="text" name="mail[name]" value="',$mail['name'],'" size="40"></td>
				</tr>
				<tr>
					<td>',lt('Your Email'),': </td>
					<td><input type="text" name="mail[from]" value="',$mail['from'],'" size="40"></td>
				</tr>
				<tr>
					<td><font size="2"><span style="font-family: Arial">',lt('Subject'),': </td>
					<td><input type="text" name="mail[subject]" value="',$mail['subject'],'" size="40"></td>
				</tr>
				<tr>
					<td style="vertical-align: top;"><font size="2"><span style="font-family: Arial">',lt('Message'),': </td>
					<td><textarea name="mail[body]" rows="8" cols="50" font size="2" wrap="soft">',$mail['body'],'</textarea></span></td>
				</tr>
				<tr>
					<td><font size="2"><span style="font-family: Arial">',lt('Type the red word'),': </td>
					<td>
						<input type="text" name="mail[check]" value="" size="10">&nbsp;&nbsp;&nbsp;
						<b>black cats hate</b> <b style="color: red;">yellow</b> <b>birds</b> 
					</td>
				</tr>
				<tr>
					<td valign="top"></td>
					<td valign="top"><input type="submit" value="',lt('Send Message'),'"></td>
				</tr>
			</table>
		</form>
		';
	}
	
	function nc_contact_config() {
		echo "<div style=\"width: 75%;\">";
		
		if (!defined('NANO_CONFIG_DIR')) {
			MsgBox("NANO_CONFIG_DIR not defined! Need 0.4.5 to run...", "redbox");
			return;
		}
		if (!is_dir(NANO_CONFIG_DIR)) {
			MsgBox("'boss/".NANO_CONFIG_DIR."' not found!", "redbox");
			return;
		}
		if (!is_writable(NANO_CONFIG_DIR)) {
			MsgBox("'boss/".NANO_CONFIG_DIR."' not writeable!", "redbox");
			return;
		}
		
		global $NANO;
		global $NanoCMS;
		
		$link = $NanoCMS['admin_filename'].'?tweak='.$_GET['tweak'];
		$config_file = NANO_CONFIG_DIR.'nc_contact.dat';
		
		// create default configuration, if not exists
		if (!file_exists($config_file)) {
			$fn = fopen($config_file, "w");
				fputs($fn, "yourname@your-domain.com\n");
				fputs($fn, "your name\n");
				fputs($fn, "subject prefix\n");
			fclose($fn);
			
			chmod($config_file, 0777);
			
			MsgBox("initial configuration created", "greenbox");
		}
		
		// perform actions
		switch ($_POST['action']) {
			case 'save_config':
				$email	= trim($_POST['email']);
				$name	= trim($_POST['name']);
				$prefix	= trim($_POST['prefix']);
				
				$fn = fopen($config_file, "w");
					fputs($fn, $email."\n");
					fputs($fn, $name."\n");
					fputs($fn, $prefix."\n");
				fclose($fn);
				
				MsgBox("configuration updated", "greenbox");
				
				break;
		}
		
		// load config
		$nc_config = file($config_file);
		
		// display config-form
		echo "<form method=\"post\" action=\"",$link,"\">\n";
		echo "<input type=\"hidden\" name=\"action\" value=\"save_config\">\n";
		echo "<table border=\"0\" cellpadding=\"2\" cellspacing=\"0\">\n";
		
		echo "<tr><td>Your Email:</td><td><input type=\"text\" name=\"email\" value=\"",$nc_config[0],"\" size=\"35\"></td></tr>\n";
		echo "<tr><td>Your Name:</td><td><input type=\"text\" name=\"name\" value=\"",$nc_config[1],"\" size=\"35\"></td></tr>\n";
		echo "<tr><td>Subject prefix:</td><td><input type=\"text\" name=\"prefix\" value=\"",$nc_config[2],"\" size=\"35\"></td></tr>\n";
		echo "<tr><td>&nbsp;</td><td><input type=\"submit\" name=\"submit\" value=\"Save\"></td></tr>\n";
		
		echo "</table>\n";
		echo "</form>\n";
		
		echo "</div>";
	}
?>