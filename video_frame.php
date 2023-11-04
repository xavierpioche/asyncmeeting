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
      <title><?php echo get_label(34,$language); ?></title>
	<link rel='stylesheet' href='/css/style.css' type='text/css' />
    </head>
    <body>
	<script type="text/javascript" src="/js/dashboard.js"></script>
      <h1><?php echo get_label(34,$language); ?></h1>
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
		$a_id=$_GET['a_id'];
		$m_id = agendum_get_my_meeting($a_id);
		if (meeting_is_participant($m_id, $user_id))
                        {

?>
	<table width=100% height=100% border=1>
	<tr><td align=center>
		<table>
		<tr><td align=left>
		<?php 
			//echo $_GET['a_id'];
			if ($a_id==-1) {
				// il faut proposer de rajouter une video
			} else {
				// on recupere les videos du sujet
				if( !isset($_GET['v_id']) || empty($_GET['v_id']) )
				{
					$arr_videos=agendum_get_videos($a_id);
				} else {
					$v_id=$_GET['v_id'];
					$arr_videos=agendum_get_videos($a_id,$v_id);
				}
				//print_r($arr_videos);
		?>
			<video id="vid" src="<?php echo $arr_videos[0]['video_link']; ?>" controls></video> 
       			<script type="text/javascript" src="/js/video.js"></script>          
		        <br>
		        <h1></h1>
		            <b><?php echo $arr_videos[0]['video_name'];?></b>
		            <br><br>
		            <form name="myForm" id="myForm" action="http://www.asyncmeeting.com/video_save_comments.php?a_id=<?php echo $a_id; ?>&v_id=<?php echo $arr_videos[0]['video_id']; ?>" method="POST">
		            <input type="hidden" name="VideoName" value="<?php echo $arr_videos[0]['video_id'] ?>">
				<table width=100%><tr><td>
		                <table>
		                    	<thead><tr><th>New Comments:</th></tr></thead><tbody>
               			    	<tr><td id="petCell"><input type="button" id="addPet" value="Add Comments" /><br /></td></tr>
					</tbody>
		                </table>
				</td><td>
				<table>
					<thead><tr><th colspan=2>Comments:</th></tr></thead><tbody>
					<?php
						$c_arr=video_comments_list($arr_videos[0]['video_id']);
						foreach($c_arr as $values)
						{
							echo "<tr><td>".$values['comment_time']."</td><td>".$values['comment_value']."</td></tr>";
						}
					?>
					</tbody>	
				</table>
				</td></tr>
            			<tr><td><br><input type="submit" name="submit" value="<?php echo get_label(35,$language);?>"></td></tr>
				</table>
            			</form>

		        <script type="text/javascript" src="/js/comments.js"></script> 
		<?php
				
			}
		?>
		</td></tr>
		<tr><td>
			<?php
				echo "<table><thead><tr><th>";
					echo get_label(36,$language);
				echo "</th></tr><tbody>";
				if( isset($_GET['v_id']) || !empty($_GET['v_id']) )
				{
					$arr_videos=agendum_get_videos($a_id);
				} 
				for($i=0;$i<count($arr_videos);$i++)
				{
					echo "<tr><td><a href=video_frame.php?a_id=$a_id&v_id=".$arr_videos[$i]['video_id'].">".$arr_videos[$i]['video_name']."</a></td></tr>";
				}
				echo "</tbody></table>";
			?>
		</td></tr>
		</table>
	</td></tr>
	</table>

<?php
	} else {
		// ce n est pas notre agendum
		echo "not authorized";
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

