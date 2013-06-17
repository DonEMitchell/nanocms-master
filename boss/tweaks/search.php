<?php

$details = new Tweak( 'simple_search' );
$details->addTweak( 'search', 'search_form' );
$details->addTweak( 'search_results', 'search_results' );
$details->Author('Zorchenhimer');
$details->Description( 'A simple search tweak' );

define('_DEBUG_', false);  // set to false to disable the debugging messages.
define('_SEARCH_POST', true); // set this to false if you want to use the GET method instead of POST when searching

function dbg($info) {
	if( _DEBUG_ )
		echo "<!-- DEBUG [simple-search]: $info -->\n";
}

function htmlentities_charset_z( $html ) {
	return htmlentities( $html, null, NANO_CHARSET );
}

if( !defined('NANO_SLUGWORD') ) {
	define('NANO_SLUGWORD', "slug");
	dbg("defined NANO_SLUGWORD");
} else {
	dbg("NANO_SLUGWORD defined as '".NANO_SLUGWORD."'");
}

function setup_results() {
	dbg("Search results template doesn't exist.  Creating now.");
	$index = file('index.php');
	if( $out_file = @fopen('search.php','x') )
		dbg("search results template opened");
	else
		dbg("error creating search results template");

	foreach( $index as $line ) {
		if( strstr($line,'show_content_slug()') ) {
			dbg("found line");
			$line = str_replace('show_content_slug()','runTweak("search_results")',$line);
		}
		fwrite($out_file,$line);
	}
	fclose($out_file);
	dbg("finished setup_results()");
}

function search_form($pg=false) { 
	if( !@file('search.php') )
		setup_results();
	else
		dbg("search template found");
?>
	<object><form action="search.php" method="<?php echo _SEARCH_POST? "post" : "get" ?>">
	<input type="text" size="10" name="query" /><?php echo ( !$pg ? '<br />' : '' )?>
	<input type="submit" value="Search" />
	</form></object>
<?php 
}

function get_excluded() {
	// this file needs to be a semi-colon separated list
	$list = file('cp/tweaks/search/excluded.txt');
	return $list[0];
}

function search_results() {
	$query = htmlentities_charset_z( $_REQUEST['query'] );
?>
	<h2>Search</h2>
	<p>Results for&nbsp;&nbsp;<b><?php echo $query?></b></p>
	<p><?php search_form(true)?></p>
	
	<p>
<?php 
	if( !$query) {
		echo '<span style="font-weight: bold">Error: Empty search query.</span>';
	} else {
	$pageDir = scandir('cp/pages');
	$found = "";
	$excluded = get_excluded();	
	$x = 0;
	
	foreach( $pageDir as $obj ) {
		if( $obj[0] != '.' && stristr($obj, '.php') && !stristr($excluded, "$obj;") ) {
			$contents = file("cp/pages/$obj");
			$line_numb = 0;
			foreach( $contents as $line ) {
				if( stristr($line,$query) && !stristr($found,$obj) ) {
					$found = "$found;$obj";
					$slugName = str_replace('.php','',$obj);
					$prettyName = ucwords(str_replace('-',' ',$slugName));
					
					echo "<a href=\"index.php?".NANO_SLUGWORD."=$slugName\">$prettyName</a><br />\n";
					
					echo strip_tags($line) . "<br /><br />\n\n";
					
				}
				$line_numb++;
			}
		}
	}
	
	if( !$found )
		echo '<span style="font-weight: bold;">No matches found</span>';
	}
	
	echo '</p>';
}

?>
