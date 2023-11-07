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
			if($_GET['is_mod']==1)
			{
				$is_mod=true;
			} else {
				$is_mod=false;
			}
//----------------------
                   // echo "Welcome, " . $user_data['first_name'] . ' ' . $user_data['last_name'] . "<br>"
                    //     . "Your token is " . $user_data['token'] . " your id is ". $user_id; 
			if ($is_mod) {
				$a_text=$_POST['a_text'];
				agendum_add_in_meeting($m_id,$a_text);
				header('Location: meeting_show.php?m_id='.$m_id);
			} else {
				$old_text=agendum_get_name($a_id);
				echo "<form name=form1 action=agendum_add.php?is_mod=1&m_id=".$m_id." method=post>";
				echo "<input size=50 type=text name=a_text value='".$old_text."'><br>";
				echo "<input type=submit value='".get_label(35,$language)."'><br><br><br>";
				echo "<a href=meeting_show.php?m_id=".$m_id.">".get_label(15,$language)."</a>";
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
} catch (PDOException $e) {
	echo 'Database error. ' . $e->getMessage();
}
?>

