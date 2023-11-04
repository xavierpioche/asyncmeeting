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

	$email=$_POST['username'];
if (find_user_by_username($email)==-1)
{
	$activation_code = generate_activation_code();
	if (register_user($email, $activation_code)) {
		send_activation_email($email, $activation_code);
	}

	echo "$email , $activation_code";
//header('Location: signin.php');
} else {
	echo "l email existe deja";
}

} catch (PDOException $e) {

            echo 'Database error. ' . $e->getMessage();

}



?>
