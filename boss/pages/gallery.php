<h2>Gallery</h2>
<hr>
<?php
	# SETTINGS
	$max_width = 100;
	$max_height = 100;
	

	function getPictureType($ext) {
		if ( preg_match('/jpg|jpeg/i', $ext) ) {
			return 'jpg';
		} else if ( preg_match('/png/i', $ext) ) {
			return 'png';
		} else if ( preg_match('/gif/i', $ext) ) {
			return 'gif';
		} else {
			return '';
		}
	}
	
	function getPictures() {
		global $max_width, $max_height;
		if ( $handle = opendir("./images/") ) {
			$lightbox = rand();
			echo '<ul id="pictures">';
			while ( ($file = readdir($handle)) !== false ) {
	if ( !is_dir("./images/".$file) ) {
					$split = explode('./images/', $file); 
					$ext = $split[count($split) - 1];
					if ( ($type = getPictureType($ext)) == '' ) {
						continue;
					}
					if ( ! is_dir('./images/thumbs') ) {
						mkdir('./images/thumbs');
					}
					if ( ! file_exists('./images/thumbs/'.$file) ) {
						if ( $type == 'jpg' ) {
							$src = imagecreatefromjpeg($file);
						} else if ( $type == 'png' ) {
							$src = imagecreatefrompng($file);
						} else if ( $type == 'gif' ) {
							$src = imagecreatefromgif($file);
						}
						if ( ($oldW = imagesx($src)) < ($oldH = imagesy($src)) ) {
							$newW = $oldW * ($max_width / $oldH);
							$newH = $max_height;
						} else {
							$newW = $max_width;
							$newH = $oldH * ($max_height / $oldW);
						}
						$new = imagecreatetruecolor($newW, $newH);
						imagecopyresampled($new, $src, 0, 0, 0, 0, $newW, $newH, $oldW, $oldH);
						if ( $type == 'jpg' ) {
							imagejpeg($new, './images/thumbs/'.$file);
						} else if ( $type == 'png' ) {
							imagepng($new, './images/thumbs/'.$file);
						} else if ( $type == 'gif' ) {
							imagegif($new, './images/thumbs/'.$file);
						}
						imagedestroy($new);
						imagedestroy($src);
					}
					echo '<li><a href="./images/'.$file.' "class="thumbnail" rel="lightbox['.$lightbox.']">';
					echo '<img class="thumbnail" src="./images/thumbs/'.$file.'" alt="" />';
					echo '</a></li>';
				}
			}
			echo '</ul>';
		}
	}
?> 
 <style type="text/css">
#pictures li {
	float:left;
	height:<?php echo ($max_height + 50); ?>px;
	list-style:none outside;
	width:<?php echo ($max_width + 100); ?>px;
	text-align:center;
}
img {
	border:0;
	outline:none;
}
</style>

</head>
<body>

<?php getPictures(); ?>

 
</body>
</html>
