<?php
include 'config/globals.php';
include 'common.php';
include 'common_meeting.php';
include 'common_videos.php';

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
			$c_id=$_GET['c_id'];
			$v_id=$_GET['v_id'];
			$m_id=$_GET['m_id'];
			$a_id=$_GET['a_id'];
//----------------------
                   // echo "Welcome, " . $user_data['first_name'] . ' ' . $user_data['last_name'] . "<br>"
                    //     . "Your token is " . $user_data['token'] . " your id is ". $user_id; 
			video_comments_delete($v_id,$c_id);
			
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
} catch (PDOException $e) {
	echo 'Database error. ' . $e->getMessage();
}
?>

