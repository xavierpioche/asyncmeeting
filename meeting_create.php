<?php
include 'config/globals.php';
include 'common.php';
include 'common_meeting.php';

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
      <title><?php echo get_label(24,$language); ?></title>
	<link rel='stylesheet' href='/css/style.css' type='text/css' />
    </head>
    <body>
      <h1><?php echo get_label(24,$language); ?></h1>
      <p>
        <?php 
            $redis = new Redis(); 
            $redis->connect($redis_db, $redis_port);
            if ($redis->exists($_COOKIE['username'])) {
                $user_data = unserialize($redis->get($_COOKIE['username']));                    
                if ($_COOKIE['token'] == $user_data['token']) {                 
			$user_id=find_user_by_username($_COOKIE['username']);
//----------------------
                   // echo "Welcome, " . $user_data['first_name'] . ' ' . $user_data['last_name'] . "<br>"
                    //     . "Your token is " . $user_data['token'] . " your id is ". $user_id; 
?>
	<table width=100% height=100% border=1>
	<tr><td align=center>
		<form name=form1 action=meeting_create_process.php method=post>
		<table border=1 width=600>
		<tr><td align=center colspan=2><?php echo get_label(24,$language); ?></td></tr>
		<tr>
			<td align=center><?php echo get_label(27,$language); ?></td>
			<td align=center><input type=text name="meeting_name" id="meeting_name" maxlength=100></td>
		</tr>
		<tr><td colspan=2 class=inter>&nbsp;</td></tr>
		<tr><td align=center><?php echo get_label(25,$language); ?></td>
		    <td id="agendaCell" align=center>
			<input type="button" id="addagendum" value="+" /><br>
		    </td>
		</tr>
		<tr><td align=center><?php echo get_label(26,$language); ?></td>
		    <td id="partsCell" align=center>
			<input type="button" id="addparts" value="+" /><br>
		    </td>
                 </tr>
		<tr><td colspan=2 class=inter>&nbsp;</td></tr>
		<tr><td align=center colspan=2><input type=submit name=submit value=<?php echo get_label(32,$language); ?>></td></tr>
		<tr><td colspan=2 class=inter>&nbsp;</td></tr>
		<tr><td colspan=2><a href=dashboard.php><?php echo get_label(15,$language); ?></a></td></tr>
		</table>
		</form>
	</td></tr>
	</table>

<?php
//----------------------
                } else {
                    echo "Invalid token.";
                }
            } else {
                  echo "Access denied.";
            }                         
        ?>

      </p>
  <script type="text/javascript" src="/js/meetings.js"></script>
  </body>
</html>
<?php
} catch (PDOException $e) {
	echo 'Database error. ' . $e->getMessage();
}
?>

