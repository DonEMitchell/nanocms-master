<?php

$lbackup = new Tweak( 'nano Backup 0.3' );
$lbackup->addTweak( 'after-logged-in', 'lbackupmain' );
$lbackup->Author('Andrew');
$lbackup->Description( 'nano Backup 0.3' );

function lbackupmain() {

//the tweak tries to go to the correct location. if problem type in full path below
//e.g. = "cp/pages/" ;

chdir ('./pages');

//the search for pages and zip bit
$zip = new ZipArchive();


if ($zip->open('tempfile.zip', ZIPARCHIVE::CREATE) !== TRUE) {
    die ("Could not open archive - please tell webmaster");
}

foreach (glob ('*.php') as $f) {
    $zip->addFile(realpath($f)) or die ("ERROR: Could not add file: $f - please tell webmaster");
}

$zip->close();
 
?> 

<?

//the date, time and random bit

$rand1 = rand(200, 3000) ;
$ae1 = date("dmy") ;
$ae3 = date("Hi");
$ae2 = "nanobackup"."_".$ae1."_".$ae3."_".$rand1.".zip";

//off we go to your backup directory

chdir ('../../backup');
$backupb = getcwd();
$backup1 = $backupb."/";

//back we go to your data/pages directory

chdir ('../cp/pages');

//the rename and move to backup directory

rename("tempfile.zip", "$backup1"."$ae2");   
       
}

?>