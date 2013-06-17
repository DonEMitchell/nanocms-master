<?php
	$lightbox = new Tweak('Lightbox Plus');
	$lightbox->Author('yoit');
	//$lightbox->Version('0.1');
	$lightbox->Description('Use the Lightbox+ script to zoom images.');
	$lightbox->addTweak('head', 'lightbox_head');
	
	function lightbox_head() {
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"boss/tweaks/lightbox_plus/lightbox.css\">\n";
		echo "<script src=\"boss/tweaks/lightbox_plus/spica.js\" type=\"text/javascript\"></script>\n";
		echo "<script src=\"boss/tweaks/lightbox_plus/lightbox_plus.js\" type=\"text/javascript\"></script>\n";
	}
?>