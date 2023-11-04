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
			$u_id=$user_id;
			$r_id=$_GET['r_id'];
			$r=$_GET['r'];
			$u_mail=$_COOKIE['username'];
			if ($r == 1)
			{
				meeting_del_participants($m_id,$u_id);
				meeting_add_participants($m_id,$u_id,$r_id);
				meeting_invite_remove($m_id,$u_mail);		
			} elseif ($r == 0) {
				meeting_invite_remove($m_id,$u_mail);		
			}
		//header('Location: dashboard.php');
//----------------------
                } else {
                    echo "Invalid token.";
                }
            } else {
                  echo "Access denied.";
            }                         
} catch (PDOException $e) {
	echo 'Database error. ' . $e->getMessage();
}
?>

