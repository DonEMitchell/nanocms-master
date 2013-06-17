<?php
$addthis = new Tweak( 'AddThis' );
$addthis->addTweak( 'template-addthis', 'addthis' );
$addthis->Author('Rophenk (tweak author)');
$addthis->Description( 'add "addthis.com" button to your page' );

//to configure your addthis.com button, please see the code below

function addthis() {
?>
<script type="text/javascript">var addthis_pub="YourAddthis.comAccountName";</script>

<a href="http://www.addthis.com/bookmark.php" onmouseover="return addthis_open(this, '', '[URL]', '[TITLE]')" onmouseout="addthis_close()" onclick="return addthis_sendto()">

<img src="http://s7.addthis.com/static/btn/lg-share-en.gif" width="125" height="16" border="0" alt="Bookmark and Share" style="border:0"/></a>

<script type="text/javascript" src="http://s7.addthis.com/js/152/addthis_widget.js"></script>

<?php
}
?>

<!-- <p> to add this tweak just put this code on template page <?php // runTweak( 'template-addthis' ); ?> </p> -->
