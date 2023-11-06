<?php
include 'config/globals.php';
include 'common.php';
include 'common_meeting.php';
include 'common_agendum.php';

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
      <title><?php echo get_label(37,$language); ?></title>
	<link rel='stylesheet' href='/css/style.css' type='text/css' />
    </head>
    <body>
	<script type="text/javascript" src="/js/dashboard.js"></script>
      <h1><?php echo get_label(37,$language); ?></h1>
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
			$m_id=$_GET['m_id'];
			$a_id=$_GET['a_id'];
			if (agendum_verify_meeting($m_id,$a_id))
			{

?>
	<table width=100% height=100% border=1>
	<tr><td align=center>
		<form name=form1 method=post action=video_insert_link_process.php>
			<input type="hidden" name="a_id" value="<?php echo $_GET['a_id'];?>">
			<input type="hidden" name="m_id" value="<?php echo $_GET['m_id'];?>">
			<input type="text" name="v_url" size=100 value="https://exemple.com/myvideo.mp4"><br>
			<input type="text" name="v_name" size=50><br><br>
			<input type=submit name="submit" value=<?php echo get_label(35,$language); ?>>
		</form><br>
		<?php
		echo "<a href=video_frame.php?m_id=$m_id&a_id=$a_id>".get_label(15,$language)."</a>";
		?>
	</td></tr>
	</table>

<?php
			} else {
				echo "this is not your agendum";
			}
//----------------------
                } else {
                    //echo "Invalid token.";
			header('Location: index.php');
                }
            } else {
                  //echo "Access denied.";
			header('Location: index.php');
            }                         
        ?>

      </p>
  </body>
</html>
<?php
} catch (PDOException $e) {
	echo 'Database error. ' . $e->getMessage();
}
?>

