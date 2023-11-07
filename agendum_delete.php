<?php
include 'config/globals.php';
include 'common.php';
include 'common_meeting.php';
include 'common_videos.php';
include 'common_agendum.php';

try {
         $db_name     = $database;
         $db_user     = $user;
         $db_password = $password;
         $pdo = new PDO('mysql:host=' . $db_host . '; dbname=' . $db_name, $db_user, $db_password);
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
         $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 

            $redis = new Redis(); 
            $redis->connect($redis_db, $redis_port);
            if ($redis->exists($_COOKIE['username'])) 
	    {
                $user_data = unserialize($redis->get($_COOKIE['username']));                    
                if ($_COOKIE['token'] == $user_data['token']) 
		{                 
			$user_id=find_user_by_username($_COOKIE['username']);
			$m_id=$_GET['m_id'];
			$a_id=$_GET['a_id'];
//----------------------
                   // echo "Welcome, " . $user_data['first_name'] . ' ' . $user_data['last_name'] . "<br>"
                    //     . "Your token is " . $user_data['token'] . " your id is ". $user_id; 
				agendum_delete_video_comments($a_id);
				agendum_delete_video($a_id);
				agendum_delete($a_id);	
			header('Location: meeting_show.php?m_id='.$m_id);
//----------------------
                } else {
                    //echo "Invalid token.";
			header('Location: index.php');
                }
            } else {
                  //echo "Access denied.";
			header('Location: index.php');
            }                         
} catch (PDOException $e) {
	echo 'Database error. ' . $e->getMessage();
}
?>

