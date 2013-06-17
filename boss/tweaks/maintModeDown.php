<?php
/*
Tweaker: Maintenance Mode Down - written by Brad Moore (bjazmoore)
Released under the GPL
Thanks to those who have helped me along the way, and those who went before me, from whom I have learned.
Some code borrowed from Alec George's Page Delete Protection tweak - Thanks

This tweaker will allow you to set the status of the nanoCMS site as unavailable to the general 
browsing public.  It features a simnple admin panel for setting site status and other features.

comments, bugs - mailto:bjazmoore@gmail.com

version .1 - March 22, 2009

*/

$maintMode = new Tweak( 'Maintenance Mode' );
$maintMode->addTweak( 'head', 'md_addHeadCSS' );
$maintMode->addInterface('maintDownInterface');
$maintMode->Author('bjazmoore, edited by <a href="http://ramblingwood.com/">Ramblingwood</a>');
$maintMode->Description( 'Maintenance Mode Down  - tweaker for disabling your site for outside viewers.' );


function md_removeBlanks ($arr) {
	$arrout = array();
	foreach($arr as $key => $value) {
		$value = rtrim($value);
		if(!empty($value))
			$arrout[] = $value;
	}
	return $arrout;
} //end of function


	

	if (!isset($_SESSION[ NANO_CMS_ADMIN_LOGGED ])) {
		//start the session to see if it is set now
		session_start();
	}
		
	//Find the document root 
	$mypath = str_replace( @$_SERVER['DOCUMENT_ROOT'], "", dirname(realpath(__FILE__)) ) . DIRECTORY_SEPARATOR;
	$mypath = str_replace("\\", "/", $mypath);  
	
	//assemble the settingsfile name	
	$settingsfn = $mypath . "maintModeDown/settings.php";

	$settings = file($settingsfn);
	$settings = md_removeBlanks($settings);
	
	//maintenance down flag
	if ($settings[1] == 'true') {
	echo <<<EOT
	<style type="text/css">
		div.md_message  {
			position:absolute;
			top:10px;
			left:50%;
			width:600px;
			margin-left:-300px;
			border:1px #c0c0c0 solid;
			background:#ffff80;
			font:bold 9pt/15px Tahoma, Verdana, Arial, sans-serif;
			padding:8px;
			text-align:center;
		  }
		div.md_alert  {
			position:absolute;
			top:50%;
			left:50%;
			background:#ff8080;
			border:1px #808080 solid;
			font:bold 9pt/15px Tahoma, Verdana, Arial, sans-serif;
			text-align:center;
			padding:10px;
			width:600px;
			margin:-50px 0 0 -300px;
		  }
	</style>
	
EOT;
		//the site is down for maintenace
		if (($settings[5] == 'true' || substr(basename($_SERVER['REQUEST_URI']), 0, strpos(basename($_SERVER['REQUEST_URI']), '?')) == 'nanoadmin.php') && isset($_SESSION[ NANO_CMS_ADMIN_LOGGED ])) {
			//if show-admin-site is set and this is admin, then it is ok display the site
			echo '<br /><div class="md_message">';
			echo 'Site is in Maintenance Mode - Non Admin users are not permitted to view site content';
			echo '</div><br />';
		} else {
			//the user is not permitted to view site content.
			echo '<div class="md_alert">';
			echo $settings[7];
			echo '</div>';
			if ($settings[3] == 'true') {
				//show the admin logon link with the site down message
				echo '<a href="data/nanoadmin.php" style="font:8px Verdana;color:gray;">Admin Login</a>';
			}
			exit();
		}
	}


		
function maintDownInterface() {
	

	//build the form target url
	$formTarget = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?tweak=' . $_REQUEST['tweak'];
	
	//Find the document root 
	$mypath = str_replace( @$_SERVER['DOCUMENT_ROOT'], "", dirname(realpath(__FILE__)) ) . DIRECTORY_SEPARATOR;
	$mypath = str_replace("\\", "/", $mypath);  
	
	//assemble the settingsfile name	
	$settingsfn = $mypath . "maintModeDown/settings.php";
	
	$settings = file($settingsfn);
	$settings = md_removeBlanks($settings);

	//if the form has been submitted - process the form
	if ($_POST['submitted'] == 'yes') {
		
		//return from form submit
		$settings[1] = 'false';
		$settings[3] = 'false';
		$settings[5] = 'false';
		$settings[7] = '';
		if (isset($_REQUEST['maintMode'])) { $settings[1] = $_REQUEST['maintMode']; }
		if (isset($_REQUEST['adminView'])) { $settings[5] = $_REQUEST['adminView']; }
		if (isset($_REQUEST['showLogin'])) { $settings[3] = $_REQUEST['showLogin']; }
		if ($_REQUEST['notice'] != '') {
			$settings[7] = $_REQUEST['notice'];
			
			//lets write the new valuse out to the settings file
			//print_r($settings);
			
			$fp = fopen($settingsfn, "w");
			if ($fp === false) {
				msgbox("<b>ERROR:</b> Failure to write Maintenance Mode settings out to the settings file","redbox");		
			} else {
				foreach($settings as $value) {	
					fwrite($fp, $value."\n");  	
				}
				// Close the file
				fclose($fp);
				msgbox("<b>Success:</b> Maintenance Mode settings written to the settings file.",'greenbox');
			}

		} else {
			msgbox("<b>Error:</b> Maintenance Mode Notice Text may not be blank!",'redbox');
		}		
		
	} 
	
	//initialize settings variables
	$modeSetting = '';
	$adminSetting = '';
	$loginSetting = '';
	$noticeSetting = 'value = "This site is down for maintenace - please try back later."';

	//populate the form values	
	if ($settings[1] == 'true') { $modeSetting = 'checked = "checked"'; }
	if ($settings[5] == 'true') { $adminSetting = 'checked = "checked"'; }
	if ($settings[3] == 'true') { $loginSetting = 'checked = "checked"'; }
	if (isset($settings[7])) {$noticeSetting = 'value = "' . $settings[7] . '"'; }	

	//show the form
	echo '<h2>Maintenance Mode Settings</h2>'; 
	echo '<form method="post" action="'.$formTarget.'">';
	echo '	<input name="maintMode" value="true" type="checkbox" '.$modeSetting.'> - Site in Maintenance Mode<br>';
	echo '  <input name="adminView" value="true" type="checkbox" '.$adminSetting.'> - Display site to admin when in Maintenance Mode<br>';
	echo '  <input name="showLogin" value="true" type="checkbox" '.$loginSetting.'> - Show login link when in Maintenance Mode<br>';
	echo '  <br>Maintenance Mode Notice Text:<br>';
	echo '  <input size="60" maxlength="90" name="notice" type="text" '.$noticeSetting.'><br>';
	echo '  <input type="text" name="submitted" value="yes" style="display: none;" /><br>';
	echo '  <input type="submit" name="submit" value="Submit">';
	echo '</form>';
	
} //end of function


?>
