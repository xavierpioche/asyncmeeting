<?php
include 'config/globals.php';
include 'common.php';
// SIGNUP
try {
         $db_name     = $database;
         $db_user     = $user;
         $db_password = $password;
         $pdo = new PDO('mysql:host=' . $db_host . '; dbname=' . $db_name, $db_user, $db_password);
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
         $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
?>
<html>
  <head>
    <link rel='stylesheet' href='css/style.css' type='text/css' />
    <title><?php echo get_label(16,$language); ?></title>
  </head>
  <body onload='document.form1.username.focus()'>
    <table border=0 width=100% height=100%>
    <tr><td align=center valign=middle>
	<form action="/sendmail_signup.php" method="post" name="form1" onSubmit="return ValidateEmail(document.form1.username)">
	<table border=1 width=400 cellpadding=0 cellspacing=0>
	<tr><td colspan=2 align=center valign=middle class=ftitle><b><?php echo get_label(17,$language); ?></b></td></tr>
	<tr><td colspan=2 class=inter>&nbsp;</td></tr>
	<tr><td class=fcol align=center width=200><label for="username"><?php echo get_label(18,$language); ?>:</label></td>
	    <td class=fcol align=center><input type="text" id="username" name="username">
	</tr>
	<tr><td colspan=2 align=center><input type="submit" value="<?php echo get_label(13,$language); ?>"></td></tr>
	</table>
	<br>
	<a href="index.php" class=lien><?php echo get_label(15,$language); ?></a>
    </form>         
    <script src="js/validate.js"></script>
  </body>
</html>
<?php
} catch (PDOException $e) {
	echo 'Database error. ' . $e->getMessage();
}
?>
