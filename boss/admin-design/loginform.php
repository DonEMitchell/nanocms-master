<html>
<head>
<!-- (c) 2009 Cripez - www.cripez.com - Build exclusively to NanoCMS. -->
<title><?php _lt('NanoCMS Admin Login'); ?></title>
<link rel="stylesheet" href="login.css"/>
<style type='text/css'>
</style>
<?php runTweak('login-head'); ?>
</head>
<body>
	<div id="conteudo">
        <div id="login_field" align="center">
        <div id="login">
        <table cellpadding='8'>
        <form action='' method='post' accept-charset='utf-8'>
        <tr class='th'><th colspan=2 align='center'><?php _lt('NanoCMS Login'); ?></th></tr>
        <tr><td><?php _lt('Username'); ?></td><td><input type='text' name='user'></td></tr>
        <tr><td><?php _lt('Password'); ?></td><td><input type='password' name='pass'></td></tr>
        <tr><td colspan='2' align='right' class="botao"><input type="image" src="images/bt_login.png" value="Submit" alt="Submit"></td></tr>
        </form>
        </table>
        <?php runTweak('login-footer'); ?>
        <div id="copyrights">&copy; <a href="http://nanocms.in" target="_blank">NanoCMS</a>, <a href="http://KalyanChakravarthy.net/">Kalyan</a>, <a href='http://www.cripez.com/'>Designed by Cripez</a></div>
        </div>
      </div>
    </div>
</body>
</html>