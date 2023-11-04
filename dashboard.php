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
                   // echo "Welcome, " . $user_data['first_name'] . ' ' . $user_data['last_name'] . "<br>"
                    //     . "Your token is " . $user_data['token'] . " your id is ". $user_id; 
?>
	<table width=100% height=100% border=1>
	<tr><td align=center>
		<table border=0 width=600>
		<tr><td align=center colspan=4><a href="meeting_create.php"><?php echo get_label(24,$language); ?></a></td></tr>
		<tr><td align=center valign=top>
			<table border=1>
			<thead>
			<tr><th align=center><?php echo get_label(20,$language); ?></th></tr>
			</thead>
			<tbody>
			<?php
				// im the owner
				$all_meetings=meeting_list($user_id);
				foreach($all_meetings as $value)
				{
					echo "<tr><td align=center><a href=meeting_show.php?m_id=$value[0]>$value[1]</a></td></tr>";
				}
			?>	
			</tbody>
			</table>
		</td>
		<td align=center valign=top>
			<table border=1>
			<thead>
			<tr><th align=center><?php echo get_label(21,$language); ?></th></tr>
			</thead>
			<tbody>
			<?php
				// im accountable
				$all_meetings=meeting_list_by_role($user_id,1);
				foreach($all_meetings as $value)
				{
					echo "<tr><td align=center><a href=meeting_show.php?m_id=$value[0]>$value[1]</a></td></tr>";
				}
			?>	
			</tbody>
			</table>
		</td>
		<td align=center valign=top>
			<table border=1>
			<thead>
			<tr><th align=center><?php echo get_label(22,$language); ?></th></tr>
			</thead>
			<tbody>
			<?php
				// im consulted
				$all_meetings=meeting_list_by_role($user_id,2);
				foreach($all_meetings as $value)
				{
					echo "<tr><td align=center><a href=meeting_show.php?m_id=$value[0]>$value[1]</a></td></tr>";
				}
			?>	
			</tbody>
			</table>
		</td>
		<td align=center valign=top>
			<table border=1>
			<thead>
			<tr><th align=center><?php echo get_label(23,$language); ?></th></tr>
			</thead>
			<tbody>
			<?php
				// im informed
				$all_meetings=meeting_list_by_role($user_id,3);
				foreach($all_meetings as $value)
				{
					echo "<tr><td align=center><a href=meeting_show.php?m_id=$value[0]>$value[1]</a></td></tr>";
				}
			?>	
			</tbody>
			</table>
		</td></tr>
		<tr><td colspan=4 align=center>
			<table border=0>
			<thead>
			<tr><th align=center colspan=2><?php echo get_label(30,$language); ?></th></tr>
			</thead>
			<tbody>
			<?php
				// im invited
				$all_meetings=meeting_list_by_invitation($_COOKIE['username']);
				$rarr=[0=>"R",1=>"A",2=>"C",3=>"I"];
				foreach($all_meetings as $value)
				{
					$as=$rarr[$value[2]];
					echo "<tr><td align=center>$value[1]&nbsp;[$as]</td><td>&nbsp;<a href=meeting_invite_response.php?m_id=$value[0]&u_id=$user_id&r_id=$value[2]&r=1>Y</a>&nbsp;&nbsp;&nbsp;<a href=meeting_invite_response.php?m_id=$value[0]&u_id=$user_id&r_id=$value[2]&r=0>N</a>&nbsp;</td></tr>";
				}
			?>
			</tbody>
			</table>
		</td></tr>
		<tr><td colspan=4 class=inter>&nbsp;</td></tr>
		<tr><td colspan=4 align=center><a href=logout.php>signout</a></td></tr>
		</table>
	</td></tr>
	</table>

<?php
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

