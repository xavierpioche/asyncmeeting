<?php
include 'config/globals.php';
include 'common.php';
include 'common_meeting.php';
include 'common_agendum.php';
include 'common_videos.php';

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
			$m_id=$_POST['m_id'];
			$a_id=$_POST['a_id'];
			$v_url=$_POST['v_url'];
			$v_name=$_POST['v_name'];
			if(empty($v_name)) $v_name="noname";
			if (agendum_verify_meeting($m_id,$a_id))
			{
				video_insert_link($m_id,$a_id,$user_id,$v_url,$v_name);
			}
			header('Location: video_frame.php?m_id='.$m_id.'&a_id='.$a_id);
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

