<BR>
<b><a href="http://www.nanocms.co.uk">nanoCMS Community</a></b><BR>
A small fast loading gpl licensed content management system (cms).<BR><P>
<BR>
<b>Tunned by master zdejota</b><BR>
<b>Credits</b><BR>
<P>nanoCMS creator:<a href="http://kalyanchakravarthy.net">Kalyan Chakravarthy</a><BR>
<a href="http://www.ramblingwood.com">Alec Gorge</a><BR>
<a href="http://www.andrewemmett.co.uk">Andrew Emmett</a><BR>
Tikakino<BR>
<a href="http://www.zorchenhimer.com">Zorchenhimer</a><BR>
<body>
<?php

echo "<br />";
echo "<b>Server Details</b>";
echo "<br />";
echo "<br />";
echo $_SERVER['HTTP_HOST'] ;
echo "<br />";
echo 'Current PHP version: ' . phpversion() ;
echo "<br />";
echo 'Path to admin directory: ' . getcwd();
echo "<br />";
echo 'UPtime: ' . system("uptime");
echo "<br />";
echo 'Kernel: ' . system("uname -a");
echo "<br />";
echo 'Memory Usage (MB): ' . system("free -m");
echo "<br />";
echo 'Disk Usage: ' . system("df -h");
echo "<br />";
echo 'CPU INFO: ' . system("cat /proc/cpuinfo | grep \"model name\|processor\"");

?>
