<?php
/*
SimpleHits Tweaker for NanoCMS 0.4

Written by bjazmoore (AKA: Brad Moore)
  email at: bjazmoore@gmail.com

Version 1.3 - added an admin option to suppress page count data on public pages
Version 1.2 - fixed a problem with file paths on Unix systems
Version 1.1 - added hit stats to main admin intro page
Version 1.0 - original release
released under the GPL - version 2 (see it here: http://www.gnu.org/licenses/old-licenses/gpl-2.0.txt)

**INSTALLING**

1) Decompress the zip file.
2) Copy the tweaker file simpleHits.php to the /data/tweaks folder.
3) Copy (from the archive) or create a folder called simpleHits in the /data/tweaks folder.
4) Make the simpleHits folder world write-able.
5) Log into your nanoCMS site and enter the Admin panel.
6) Activate the simpleHits Tweak
7) Configure the tweak via the tweak interface

Have Fun!

*/


$details = new Tweak( 'simpleHits' );
$details->addTweak( 'content-area-end', 'simpleHits' );
$details->addTweak( 'admin-head-content', 'sh_applyStyle' );
$details->addTweak( 'intro-page', 'showSimpleHitsStats' );
$details->addInterface('simpleHitsInterface');
$details->Author('bjazmoore');
$details->Description( 'Very simple hit counter' );


function showMe($content) {
	echo "<br>[" . $content . "]";
}


function sh_applyStyle() {
	echo <<<EOT
	<style>
	
	h2.center {
		text-align: center;
	}
	
	DIV.Hits {
		padding:5px;
		margin:0 auto
	}
	
	TABLE {
		text-align: center;
	 font-family:arial;
     font-size:10pt;
     border-style:solid;
     border-color:black;
	}
	
	TABLE#SHTABLE1
  { 
     border-collapse:collapse;
     background-color:#C3D9FF;
     width:580px;
     border-width:0px;
     text-align: center;     
  }

	TABLE#SHTABLE2
  { 
     border-collapse:collapse;
     background-color:#C3D9FF;
     width:60%; 
	 margin-left:20%; 
	 margin-right:20%
     border-width:0px;
     text-align: center;     
  }
  
  
  TH.SHTABLE
  {
     font-size:10pt;
     color:black;
     border-style:solid;
     border-width:1px;
  }


  TR.SHTABLE
  { 
     height:20pt;
  }

  TD.SHTABLE
  {  
     font-size:10pt;
     background-color:#DAE8FF;
     color:black;
     border-style:solid;
     border-width:1px;
     text-align:center;
  }
  </style>
EOT;

	
} //end of function



function simpleHits($content) {
	
	if ($content == "Copyright Notice") {
		
		if (!isset($_SESSION[ NANO_CMS_ADMIN_LOGGED ])) {
			//start the session to see if it is set now
			session_start();
		}
	
		$style1 = "style=\"font-size: small; font-weight: bold;\"";
		$style2 = "style=\"font-size: x-small; font-weight: normal;\"";
	
		//Find the document root 
		//$mypath = str_replace( @$_SERVER['DOCUMENT_ROOT'], "", dirname(realpath(__FILE__)) ) . DIRECTORY_SEPARATOR;
		$mypath = dirname(realpath(__FILE__)). DIRECTORY_SEPARATOR;
		$mypath = str_replace("\\", "/", $mypath);  		
		
		//assemble the logfile name	
		$logfilename = $mypath . "simpleHits/counterlog.php";
		
		$currentPage = $_GET[NANO_SLUGWORD];
	
		$hpage = getDetails('homepage');
		$slugarray = getDetails('slugs');
		$homeName = $slugarray[ $hpage ];
		
		if (is_null($currentPage)) {
			$currentPage = $homeName;
		}
	
		$pgviews = array();
		$dataOut = '';
		
	
		// Open the file for reading
		if (@file_exists($logfilename)) {
			$pgviews = file($logfilename,FILE_IGNORE_NEW_LINES);
		} else {
			//echo 'file does not exist<br>';                         <<<<<<<<<<<< add date, date flag and text
			$dt = date("F j, Y");
			$pgviews = array($dt, "true", "Page Views:", "false", "true", "false", $currentPage,0);
		}
		
		$pgviews = sh_removeBlanks($pgviews);	
		$elementCnt = count($pgviews);

		//find the current page in the array
		
		$pgfound = -1;  //flag
		for ($i = 6; $i < $elementCnt; $i++) {
			//first trim white space from right side of the string
			$pgviews[$i] = rtrim($pgviews[$i]);
			if ($currentPage == $pgviews[$i]) {			
				$pgfound = $i;
			}
		}
		
		if ($pgfound == -1) {
			//echo 'adding a new page name';
			$pgviews[] = $currentPage;
			$pgviews[] = 1;
			$pgviews[] = date("M j, Y");
			$pgvcount = 1;
		} else {
			//only increment page views if we are admin if pgviews[3] is true
			if ($pgviews[3] == 'false' or !isset($_SESSION[ NANO_CMS_ADMIN_LOGGED ])) {
				$pgviews[$pgfound+1] = $pgviews[$pgfound+1] + 1;
				$pgviews[$pgfound+2] = date("M j, Y");
			}
			$pgvcount = $pgviews[$pgfound+1];
		}
		
		//put the array back out to the file
		// Reopen the file and erase the contents
		$fp = fopen($logfilename, "w");
		if ($fp === false) {
			echo "Tweaker: <b>Simple Hit Counter</b> can not write out to log file";	
			echo "<br>Path equals: [$logfilename]";	
		} else {
			//build the output string
			if ($pgviews[5] == 'false') { 
				$output = "<br><span ". $style1 . ">" . $pgviews[2] . " " . $pgvcount . "</span>";
				if (substr($pgviews[1],0,4) == "true") { $output .= "<span ". $style2 . ">" . "&nbsp&nbsp&nbsp(since " . $pgviews[0] . ")</span>"; }
				echo $output;
			}
			foreach($pgviews as $value) {	
				$dataOut = $dataOut . $value . "\r\n";	
			}
			// Write the new count to the file
			fwrite($fp, $dataOut);
			// Close the file
			fclose($fp);
		}
	}
	
} //end of function


function showSimpleHitsStats() {
	
	//Find the document root 
	//$mypath = str_replace( @$_SERVER['DOCUMENT_ROOT'], "", dirname(realpath(__FILE__)) ) . DIRECTORY_SEPARATOR;
	$mypath = dirname(realpath(__FILE__)). DIRECTORY_SEPARATOR;
	$mypath = str_replace("\\", "/", $mypath);  
	
	//assemble the settingsfile name	
	$settingsfn = $mypath . "simpleHits/counterlog.php";
	
	$settings = file($settingsfn);
	$settings = sh_removeBlanks($settings);
	
	if ($settings[4] == "true") {
		echo '<div class="Hits"><h2 class="center">Simple Hits Statistics for this Site</h2><TABLE ID="SHTABLE2">';
		simpleHitsStats($settings);
		echo '</div>';
	}
	
} //end function


function simpleHitsInterface() {
	

	//build the form target url
	$formTarget = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?tweak=' . $_REQUEST['tweak'];
	
	//Find the document root 
	//$mypath = str_replace( @$_SERVER['DOCUMENT_ROOT'], "", dirname(realpath(__FILE__)) ) . DIRECTORY_SEPARATOR;
	$mypath = dirname(realpath(__FILE__)). DIRECTORY_SEPARATOR;
	$mypath = str_replace("\\", "/", $mypath);  
	
	//assemble the settingsfile name	
	$settingsfn = $mypath . "simpleHits/counterlog.php";
	
	$settings = file($settingsfn);
	$settings = sh_removeBlanks($settings);

	//if the form has been submitted - process the form
	if ($_POST['submitted'] == 'yes') {
		
		//return from form submit
		$settings[0] = $_REQUEST['hitDate'];
		$settings[1] = 'false';
		$settings[3] = 'false';
		$settings[4] = 'false';
		$settings[5] = 'false';
		$settings[2] = '';
		if (isset($_REQUEST['resetHits'])) { 
			//if it is "true" then reset hits and post new date
			//reset the settings array
			$settings = array();
			$settings[0] = date("F j, Y");
		}
		if (isset($_REQUEST['showDate'])) { $settings[1] = $_REQUEST['showDate']; }
		if (isset($_REQUEST['countAdmin'])) { $settings[3] = $_REQUEST['countAdmin']; }
		if (isset($_REQUEST['showAdminStats'])) { $settings[4] = $_REQUEST['showAdminStats']; }
		if (isset($_REQUEST['supressHits'])) { $settings[5] = $_REQUEST['supressHits']; }
		if ($_REQUEST['counterText'] != '') {
			$settings[2] = $_REQUEST['counterText'];
			
			//lets write the new valuse out to the settings file
			$fp = fopen($settingsfn, "w");
			if ($fp === false) {
				msgbox("<b>ERROR:</b> Failure to write Simple Hits settings out to the settings file","redbox");		
			} else {
				foreach($settings as $value) {	
					fwrite($fp, $value."\n");  	
				}
				// Close the file
				fclose($fp);
				msgbox("<b>Success:</b> Simple Hits settings written to the settings file.",'greenbox');
			}

		} else {
			msgbox("<b>Error:</b> Simple Hits Counter Text may not be blank!",'redbox');
		}		
		
	} 
	
	//initialize settings variables
	$resetHits = '';
	$showDate = '';
	$countAdmin = '';
	$showAdminStats = '';
	$supressHits = '';
	$counterText = 'value = "Page Views:"';

	//populate the form values	
	if ($settings[0] == 'true') { 
		$resetHits = 'checked = "checked"'; 
	} else {
		$hitDate = $settings[0];
	}
	if ($settings[1] == 'true') { $showDate = 'checked = "checked"'; }
	if ($settings[3] == 'true') { $countAdmin = 'checked = "checked"'; }
	if ($settings[4] == 'true') { $showAdminStats = 'checked = "checked"'; }
	if ($settings[5] == 'true') { $supressHits = 'checked = "checked"'; }
	if (isset($settings[2])) {$counterText = 'value = "' . $settings[2] . '"'; }	

	//show the form
	echo '<h2>Simple Hits Settings</h2>'; 
	echo '<form method="post" action="'.$formTarget.'">';
	echo '	<input name="resetHits" value="true" type="checkbox" '.$resetHits.'> - Reset Hit Counter (will reset date hits are counted from)<br>';
	echo '  <input name="showDate" value="true" type="checkbox" '.$showDate.'> - Display the date since counting began<br>';
	echo '  <input name="countAdmin" value="true" type="checkbox" '.$countAdmin.'> - Don\'t count hits when Admin visits pages<br>';
	echo '  <input name="showAdminStats" value="true" type="checkbox" '.$showAdminStats.'> - Show Simple Hits Stats on the main Admin Page<br>';
	echo '  <input name="supressHits" value="true" type="checkbox" '.$supressHits.'> - Suppress Page Hits Text on Public Viewable Pages<br>';
	echo '  <br>Hit Counter Text:<br>';
	echo '  <input size="50" maxlength="30" name="counterText" type="text" '.$counterText.'><br>';
	echo '  <input type="text" name="hitDate" value="' . $hitDate . '" style="display: none;" />';
	echo '  <input type="text" name="submitted" value="yes" style="display: none;" /><br>';
	echo '  <input type="submit" name="submit" value="Submit">';
	echo '</form>';	
	echo '<br>';
	echo '<h2>Simple Hits Statistics</h2><TABLE ID="SHTABLE1">';
	
	simpleHitsStats($settings);
	
	
	
} //end of function


function simpleHitsStats($infoArray) {
	
echo '<THEAD >
      <TR CLASS="SHTABLE">
        <TH CLASS="SHTABLE">Page</TH>
        <TH CLASS="SHTABLE">Hits</TH>
        <TH CLASS="SHTABLE">Last Visit</TH>
      </TR>
    </THEAD>   
    <TBODY>';
    
    $elementCnt = count($infoArray);
    
    if ($elementCnt < 5) {
    	echo '<TR CLASS="SHTABLE">  
		        <TD CLASS="SHTABLE" colspan="3">No Statistics Available</TD>
		      </TR>';
	} else {
	
		for ($i = 6; $i < $elementCnt; $i=$i+3) {
			echo '<TR CLASS="SHTABLE">
					<TD CLASS="SHTABLE">'.$infoArray[$i].'</TD>
			        <TD CLASS="SHTABLE">'.$infoArray[$i+1].'</TD>
			        <TD CLASS="SHTABLE">'.$infoArray[$i+2].'</TD>
				  </TR>';
			}
		}
    echo '</TBODY>
  </TABLE>';	
	
} //end function

function sh_removeBlanks ($arr) {
	$arrout = array();
	foreach($arr as $key => $value) {
		$value = rtrim($value);
		if(!empty($value))
			$arrout[] = $value;
	}
	return $arrout;
} //end of function

?>
