<?php require_once("boss/setting.php"); ?>

<!DOCTYPE HTML>
<!--
	Minimaxing 3.0 by HTML5 UP
	html5up.net | @n33co
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title><?php show_title(); ?></title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />

<link rel="stylesheet" type="text/css" href="boss/tweaks/lightbox_plus/lightbox.css">
<script src="boss/tweaks/lightbox_plus/spica.js" type="text/javascript"></script>
<script src="boss/tweaks/lightbox_plus/lightbox_plus.js" type="text/javascript"></script>
		<link href='http://fonts.googleapis.com/css?family=Ubuntu+Condensed' rel='stylesheet' type='text/css'>
		<script src="js/jquery.min.js"></script>
		<script src="js/config.js"></script>
		<script src="js/skel.min.js"></script>
		<script src="js/skel-panels.min.js"></script>
		<noscript>
			<link rel="stylesheet" href="css/skel-noscript.css" />
			<link rel="stylesheet" href="css/style.css" />
			<link rel="stylesheet" href="css/style-desktop.css" />
		</noscript>
		<!--[if lte IE 9]><link rel="stylesheet" href="css/ie9.css" /><![endif]-->
		<!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
	</head>
	<body>
	<!-- ********************************************************* -->
		<div id="header-wrapper">
			<div class="container">
				<div class="row">
					<div class="12u">
						
						<header id="header">
							<h1><a href="#" id="logo"><?php show_content_area('WebSite Name'); ?></a></h1>
<h4>
<?php show_content_area('WebSite slogan'); ?>
</h4>
							<nav id="nav">
 <?php 
	  	//show_content_area('Top Navigation');
		//show_links( link_place, format[ nolist->with out <li> or default <li>%s</li>, before, after )
		show_links('top-navigation','nolist');
	  ?>

								
				 							</nav>
						</header>
					
					</div>
				</div>
			</div>
		</div>
		<div id="main">
			<div class="container">
				<div class="row main-row">
					<div class="4u">

						<section>


  <?php show_content_area('Below Navigation'); ?>
<br />

 <?php show_sidebar(); ?>
					 
						</section>
					
						<section>
							<h2>How about some links?</h2>
							<div>
								<div class="row">
									<div class="6u">
										<ul class="link-list">

											<li><a href="#"><?php show_links('links'); ?></a></li>
										</ul>
									</div>
									<div class="6u">

									</div>
								</div>
							</div>
						</section>
						
					</div>
					<div class="8u skel-cell-mainContent">

						<section class="right-content">
					

<?php runTweak("search_results"); ?>

						</section>
					
					</div>
				</div>
			</div>
		</div>
		<div id="footer-wrapper">
			<div class="container">
				<div class="row">
					<div class="8u">
						
						<section>
							<h2>How about a truckload of links?</h2>
							<div>
								<div class="row">
									<div class="3u">
										<ul class="link-list">
</ul>
										
									</div>
								</div>
							</div>
						</section>
					
					</div>
					<div class="4u">

						<section>
							<h2>Something of interest</h2>
							<p> 
								<a href="#" class="button">Oh, please continue ....</a>
							</footer>
						</section>

					</div>
				</div>
				<div class="row">
					<div class="12u">

						<div id="copyright">
							&copy; Untitled. All rights reserved. | Design: <a href="http://html5up.net">HTML5 UP</a> | Images: <a href="http://fotogrph.com">fotogrph</a>
<?php show_content_area('Copyright Notice'); ?>
						</div>

					</div>
				</div>
			</div>
		</div>
	<!-- ********************************************************* -->
	</body>
</html>