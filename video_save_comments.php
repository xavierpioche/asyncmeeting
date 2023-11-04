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
      <title><?php echo get_label(19,$language); ?></title>
	<link rel='stylesheet' href='/css/style.css' type='text/css' />
    </head>
    <body>
	<script type="text/javascript" src="/js/dashboard.js"></script>
      <h1><?php echo get_label(19,$language); ?></h1>
      <p>
        <?php 
            $redis = new Redis(); 
            $redis->connect($redis_db, $redis_port);
            if ($redis->exists($_COOKIE['username'])) {
                $user_data = unserialize($redis->get($_COOKIE['username']));                    
                if ($_COOKIE['token'] == $user_data['token']) {                 
			$user_id=find_user_by_username($_COOKIE['username']);

//----------------------
			$a_id=$_GET['a_id'];
			$m_id = agendum_get_my_meeting($a_id);                                                                                                                      
	                if (meeting_is_participant($m_id, $user_id))
                        {

				$v_id=$_POST["VideoName"];
			        foreach ( $_POST['pets'] as $value )
        			{
			            $enr=explode(':',$value);
			            $enr_time = getStringBetween($enr[0], '[', ']');
					if (strcmp($enr_time,"undefined")==0) $enr_time="00:00.00";
			            $enr_comment = $enr[1];
				     echo "($v_id, $enr_time, $enr_comment)";
				    video_comments_save($v_id, $enr_time, $enr_comment);
				}
			}
                   // echo "Welcome, " . $user_data['first_name'] . ' ' . $user_data['last_name'] . "<br>"
                    //     . "Your token is " . $user_data['token'] . " your id is ". $user_id; 
			header("Location: video_frame.php?a_id=$a_id&v_id=$v_id");
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

