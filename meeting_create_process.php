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

		$m_name=substr($_POST['meeting_name'],0,100);
		$m_owner=$user_id;
		if (meeting_exist($m_owner,$m_name)===false)
		{
			meeting_create($m_owner,$m_name);
			$m_id=meeting_exist($m_owner,$m_name);
			// par defaut on cree un summary
			$summary=get_label(33,$language);
			meeting_create_agendum($m_id[0],$summary,1);
			// 
			foreach ($_POST['agenda'] as $value)
			{
				meeting_create_agendum($m_id[0],$value);
			}
			$scount=0;
			foreach ($_POST['participants'] as $value)
			{
				$test="myselect$scount";
				$role=$_POST[$test];
				meeting_invite_participants($m_id[0],$value,$role);
				$scount++;
			}
			meeting_add_participants($m_id[0],$m_owner,0);
			$msg=get_label(29,$language);
		} else {
			$msg=get_label(28,$language);
		}
			
?>
	<table width=100% height=100% border=1>
	<tr><td align=center>
		<table border=0>
		<tr><td align=center><?php echo $msg; ?></td></tr>
		<tr><td><a href=dashboard.php><?php echo get_label(15,$language); ?></a></td></tr>
		</table>
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
  </body>
</html>
<?php
} catch (PDOException $e) {
	echo 'Database error. ' . $e->getMessage();
}
?>

