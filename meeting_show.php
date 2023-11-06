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
      <title><?php echo get_label(31,$language); ?></title>
      <link rel='stylesheet' href='/css/style.css' type='text/css' />
    </head>
    <body>
      <h1><?php echo get_label(31,$language); ?></h1>
      <p>
        <?php 
            $redis = new Redis(); 
            $redis->connect($redis_db, $redis_port);
            if ($redis->exists($_COOKIE['username'])) {
                $user_data = unserialize($redis->get($_COOKIE['username']));                    
                if ($_COOKIE['token'] == $user_data['token']) {                 
			$user_id=find_user_by_username($_COOKIE['username']);
			$m_id=$_GET['m_id'];
			if (meeting_is_participant($m_id, $user_id))
			{
				// on est bien participant dans ce meeting
//----------------------
                   // echo "Welcome, " . $user_data['first_name'] . ' ' . $user_data['last_name'] . "<br>"
                    //     . "Your token is " . $user_data['token'] . " your id is ". $user_id; 
?>
	<table width=100% height=100% border=0>
	<tr><td align=center>
	<table border=0 width=100%>
	<tr><td align=center>
		<table border=1 width=100 class=hoverTable>
		<thead>
		<?php
			echo "<tr><th scope='col' colspan=3>";
				echo  get_label(25,$language);
			echo " : </th></tr></thead><tbody>";
			$agendum=agendum_list_by_meeting($m_id);
			foreach ($agendum as $value)
			{
				echo "<tr><td width=100><a href=video_frame.php?a_id=$value[0] target='theframe'>$value[1]</a></td>";
				echo "<td width=26px><img src=/images/edit-button.png></td><td width=26px><img src=/images/remove.png></td>";
				echo "</tr>";
			}
		?>
			<tr><td align=center colspan=3><img src=/images/more.png width=16 height=16></td></tr>
		</tbody>
		</table>
		<br>
		<table border=1 width=100%>
		<thead>
		<?php
			echo "<tr><th scope='col'>";
				echo  get_label(26,$language);
			echo " : </th></tr></thead><tbody>";
			$participants=meeting_list_participants_by_mail($m_id);
			foreach ($participants as $value)
			{
				echo "<tr><td>$value[1]</td></tr>";
			}
		?>
		</tbody>
		</table>
	</td><td align=center>
		<?php
			// quel agendum
			if (isset($_GET['a_id'])&&(is_numeric($_GET['a_id'])))
			{
				// est ce que c est le notre
				$a_id=$_GET['a_id'];
				if (!agendum_verify_meeting($m_id,$a_id))
				{
					$a_id=-1;	
				}
			} else {
				// on cherche l agendum par defaut
				$a_id = agendum_get_default($m_id);
			}
		?>
		<table border=0 width=100%>
		<tr><td align=center>
			<?php echo "<iframe name=theframe src='video_frame.php?a_id=$a_id' width=100% height=800>" ?>
			</iframe>
		</td></tr>
		</table>
	</td></tr>
	<tr><td colspan=2><a href=dashboard.php><?php echo get_label(15,$language); ?></a></td></tr>
	</table>
	</td></tr>
	</table>

<?php
			} else {
				header('location:dashboard.php');
			}
//----------------------
                } else {
			header('Location: index.php');
                    #echo "Invalid token.";
                }
            } else {
		header('Location: index.php');
                 # echo "Access denied.";
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

