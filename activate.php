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

    // sanitize the email & activation code
    if (filter_var($_GET['email'], FILTER_VALIDATE_EMAIL)) {
	if (strlen($_GET['activation_code'])<256)
	{
        	$user = find_unverified_user($_GET['activation_code'], $_GET['email']);
	        if ($user) {
?>

<html>
  <head>
    <link rel='stylesheet' href='css/style.css' type='text/css' />
    <title><?php echo get_label(16,$language); ?></title>
  </head>
  <body onload='document.form1.username.focus()'>
    <table border=0 width=100% height=100%>
    <tr><td align=center valign=middle>
	<form action="/register_signup.php" method="post" name="form1" onSubmit="return ValidateAllDouble(document.form1.username,document.form1.pwd,document.form1.pwd2)">
	<table border=1 width=400 cellpadding=0 cellspacing=0>
	<tr><td colspan=2 align=center valign=middle class=ftitle><b><?php echo get_label(17,$language); ?></b></td></tr>
	<tr><td colspan=2 class=inter>&nbsp;</td></tr>
	<input type="hidden" name="username" value="<?php echo $_GET['email']; ?>">
	<input type="hidden" name="activation" value="<?php echo $_GET['activation_code']; ?>">
	<tr><td class=fcol align=center><label for="pwd"><?php echo get_label(12,$language); ?>:</label></td>
	    <td class=fcol align=center width=200><input type="password" id="pwd" name="pwd"></td>
	</tr>
	<tr><td class=fcol align=center><label for="pwd2"><?php echo get_label(16,$language); ?>:</label></td>
	    <td class=fcol align=center width=200><input type="password" id="pwd2" name="pwd2"></td>
	</tr>
	<tr><td colspan=2 align=center><?php echo get_label(14,$language); ?></td></tr>
	<tr><td colspan=2 align=center><input type="submit" value="<?php echo get_label(13,$language); ?>"></td></tr>
	</table>
	<br>
	<a href="index.php" class=lien><?php echo get_label(15,$language); ?></a>
    </form>         
    <script src="js/validate.js"></script>
  </body>
</html>

<?php

        } else {
		echo "user inconnu ou activatin code faux";
	}
    }
}
} catch (PDOException $e) {

            echo 'Database error. ' . $e->getMessage();

        }

?>
