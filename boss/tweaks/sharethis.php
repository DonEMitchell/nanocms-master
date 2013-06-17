<?php
$sthis = new Tweak( 'sharethis' );
$sthis->addTweak( 'template-sthis', 'sthis' );
$sthis->Author('zdejota');
$sthis->Description( 'add sharethis buttons to your page' );

//to customize your sharethis button, please see the code below, replace www.site.com with your site url

function sthis() {
?>


<style type="text/css">
 
#share-buttons img {
width: 35px;
padding: 5px;
border: 0;
box-shadow: 0;
display: inline;
}
 
</style>
<!-- I got these buttons from site.com -->
<div id="share-buttons">

<!-- Facebook -->
<a href="http://www.facebook.com/sharer.php?u=http://www.site.com" target="_blank"><img src="assets/facebook.png" alt="Facebook" /></a>

<!-- Twitter -->
<a href="http://twitter.com/share?url=http://www.site.com&text=Simple Share Buttons" target="_blank"><img src="assets/twitter.png" alt="Twitter" /></a>

<!-- Google+ -->
<a href="https://plus.google.com/share?url=http://www.site.com" target="_blank"><img src="assets/google.png" alt="Google" /></a>

<!-- Digg -->
<a href="http://www.digg.com/submit?url=http://www.site.com" target="_blank"><img src="assets/diggit.png" alt="Digg" /></a>

<!-- Reddit -->
<a href="http://reddit.com/submit?url=http://www.site.com&title=Simple Share Buttons" target="_blank"><img src="assets/reddit.png" alt="Reddit" /></a>

<!-- LinkedIn -->
<a href="http://www.linkedin.com/shareArticle?mini=true&url=http://www.site.com" target="_blank"><img src="assets/linkedin.png" alt="LinkedIn" /></a>

<!-- Pinterest -->
<a href="javascript:void((function()%7Bvar%20e=document.createElement('script');e.setAttribute('type','text/javascript');e.setAttribute('charset','UTF-8');e.setAttribute('src','http://assets.pinterest.com/js/pinmarklet.js?r='+Math.random()*99999999);document.body.appendChild(e)%7D)());"><img src="assets/pinterest.png" alt="Pinterest" /></a>

<!-- StumbleUpon-->
<a href="http://www.stumbleupon.com/submit?url=http://www.site.com&title=Simple Share Buttons" target="_blank"><img src="assets/stumbleupon.png" alt="StumbleUpon" /></a>

<!-- Email -->
<a href="mailto:?Subject=Share site&Body=I%20saw%20this%20and%20thought%20of%20you!%20 http://www.site.com"><img src="assets/email.png" alt="Email" /></a>

</div>

<?php
}
?>

<!-- <p> to add this tweak just put this code on template page <?php // runTweak( 'template-sthis' ); ?>  </p> -->
