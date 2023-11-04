<?php 
include('config/globals.php');                                                                                                                    
include('common.php');


    try {

           $db_name     = $database;

           $db_user     = $user;

           $db_password = $password;

            $pdo = new PDO('mysql:host=' . $db_host . '; dbname=' . $db_name, $db_user, $db_password);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 

            $sql = 'update system_users set pwd=:pwd where username=:username and activation_code=:activation'; 


	if (filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
		$username=$_POST['username'];
		$activation=$_POST['activation'];
		if (check_pwd($_POST['pwd']))
		{
            		$stmt = $pdo->prepare($sql);
			$stmt->bindParam(':username',$_POST['username'],PDO::PARAM_STR,500);
			$stmt->bindParam(':activation',$_POST['activation'],PDO::PARAM_STR,255);
			$stmt->bindParam(':pwd',password_hash($_POST['pwd'], PASSWORD_BCRYPT),PDO::PARAM_STR,255);

            		$stmt->execute(); 

			delete_activation_code($username,$activation);
            		echo "User data saved successfully.\n<br>" ;
			echo "<a href=signin.php>Sign-in</a>";
		} else {
			echo "bad password format<br>";	
			echo "<a href=activate.php?email=$username&activation_code=$activation>Back</a>";
		}
	} else {
		echo "invalid mail format<br>";
		echo "<a href=activate.php?email=$username&activation_code=$activation>Back</a>";
	}



        } catch (PDOException $e) {

            echo 'Database error. ' . $e->getMessage();

        }

function pdo_debugStrParams($stmt) {
  ob_start();
  $stmt->debugDumpParams();
  $r = ob_get_contents();
  ob_end_clean();
  return $r;
}
?>
