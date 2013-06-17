<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo NANO_CHARSET; ?>" /> 
<title>nanoCMS 0.8 master ed -  <?php _lt("Administration Panel") ?></title>
<link rel="stylesheet" href="admin-design/admin.css" />
<script src="admin-design/jquery.js" type="text/javascript"></script>
<script src="admin-design/admin.js" type="text/javascript"></script>
<style type="text/css"></style>
<?php runTweak( 'admin-head-content' ); ?>
</head>
<body>
<div id="pagewrapper">
  <div id="page">
  	<div id="headertop">
    <div class="floatright">
    	nanoCMS Community Edition 0.8 master edition
    </div>
	<div class="viewsitelink"><a href="<?php echo NANO_CMS_PAGE; ?>" target="_blank"><?php _lt('View Site') ?></a> | <a href="?logout" ><?php _lt('Logout') ?></a></div>
    </div>
    <div id="header">
      <div id="topnav">
        <ul id="nav">
          <li class="top"><a href="?" class="top_link"><span><?php _lt('Admin Home'); ?></span></a></li>
          <li class="top"><a href="?action=addpage" class="top_link"><?php _lt('New Page'); ?></a></li>
          <li class="top"><a href="?action=showpages" class="top_link"><?php _lt('Pages & Options'); ?></a></li>
          <li class="top"><a href="?action=showareas" class="top_link"><?php _lt('Content Areas'); ?></a></li>
          <li class="top"><a href="?action=settings" class="top_link"><?php _lt('Settings'); ?></a></li>
          <li class="top" id="tdropdown"><a href="?action=tweakers" title="<?php _lt('Tweakers are Plugin like things which extend NanoCMS'); ?>" class="top_link"><span class="down"><?php _lt('Tweakers'); ?></span></a>
            <ul class="sub">
              <li class="top_first"><a href="?action=tweakers"><?php _lt('View All tweaks'); ?></a></li>
              <?php listoutInterfaces(); ?>
            </ul>
          </li>
        </ul>
      </div>
      <h1><?php _lt('Administration Panel'); ?></h1>
    </div>
    <div id="main">
      <div id="body">
        <?php runTweak( 'admin-body' ); ?>
      </div>
    </div>
    <!-- END OF MAIN DIV TAG -->
    <div class="break">&nbsp;</div>
    <div id="footer">Template Design &copy; <a href="http://www.kalyanchakravarthy.net" target="_blank">Kalyan Chakravarthy</a></div>
  </div>
</div>
<script language="javascript">
</script>
<?php runTweak('admin-body-end'); ?>
</body>
</html>