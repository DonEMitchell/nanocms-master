<?php
$gmaps = new Tweak( 'Gmaps' );
$gmaps->addTweak( 'template-gmaps', 'gmaps' );
$gmaps->Author('zdejota');
$gmaps->Description( 'add google maps to your page' );

//to configure your map, please see the code below

function gmaps() {
?>
<iframe width="300" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=porto+portugal&amp;t=h&amp;ie=UTF8&amp;hq=&amp;hnear=Porto,+Portugal&amp;ll=41.156689,-8.623925&amp;spn=0.139836,0.220757&amp;z=12&amp;vpsrc=6&amp;output=embed">
</iframe><br /><small><a href="https://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=porto+portugal&amp;t=h&amp;ie=UTF8&amp;hq=&amp;hnear=Porto,+Portugal&amp;ll=41.156689,-8.623925&amp;spn=0.139836,0.220757&amp;z=12&amp;vpsrc=6" style="color:#0000FF;text-align:left">View Larger Map</a></small>


<?php
}
?>

<!-- <p> to add this tweak just put this code on template page <?php // runTweak( 'template-gmaps' ); ?> </p> -->
