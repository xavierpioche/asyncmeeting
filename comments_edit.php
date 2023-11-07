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
				$c_text=$_POST['c_text'];
				video_comments_modify($c_id,$c_text);
				header('Location: video_frame.php?m_id='.$m_id.'&a_id='.$a_id);
			} else {
				$old_text=video_comments_get($c_id);
				echo "<form name=form1 action=comments_edit.php?is_mod=1&c_id=".$c_id."&v_id=".$v_id."&m_id=".$m_id."&a_id=".$a_id." method=post>";
				echo "<input size=100 type=text name=c_text value='".$old_text."'><br>";
				echo "<input type=submit value='".get_label(35,$language)."'><br><br><br>";
				echo "<a href=video_frame.php?m_id=".$m_id."&a_id=".$a_id."&v_id=".$v_id.">".get_label(15,$language)."</a>";
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

