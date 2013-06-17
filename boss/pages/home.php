<h2>Blog</h2>
<hr>
<p>How to access admin panel:
<br />
write boss in front of url <br />
<b>Default Login:</b><br />
admin<br />
admin<br /><br />
please change login in boss/thedata.php<br /><br />
find this line:<br />
5:"admin" <br />
and change to <br />
5:"someotherusername"<br />
<br />
find this line: 
<br />
32:"21232f297a57a5a743894a0e4a801fc3"
<br />
and replace with a md5hashed password:
<br />
for example:
<br />
<b>
 md5 -s password <br />
MD5 ("password") = 5f4dcc3b5aa765d61d8327deb882cf99</b>
<br />
it gives me 5f4dcc3b5aa765d61d8327deb882cf99, wich means password
<br />
it will looks like this:
<br />
32:"5f4dcc3b5aa765d61d8327deb882cf99"
<br />
more complex passwords, more md5 strong hash will be.
<br /><br />
<?php runTweak('sblog-page') ?>

