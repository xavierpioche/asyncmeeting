<?php

function get_label($id_label, $id_language)
{
	global $pdo;
	$sql = "select label from languages where id_label='$id_label' and id_language='$id_language'";
	$stmt = $pdo->prepare($sql);
        $stmt->execute(); 

	$data = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {         
	        $data = $row;          
        }        

	return $data['label'];
}

function check_pwd($pwd)
{
	$pattern="/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/";
	if (preg_match($pattern, $pwd)) {
		return true;
	} else {
		return false;
	}

}

function generate_activation_code(): string
{
    return bin2hex(random_bytes(16));
}

function send_activation_email(string $email, string $activation_code): void
{
    // create the activation link
    $activation_link = APP_URL . "/activate.php?email=$email&activation_code=$activation_code";

    // set email subject & body
    $subject = 'Please activate your account';
    $message = <<<MESSAGE
            Hi,
            Please click the following link to activate your account:
            $activation_link
            MESSAGE;
    // email header
    $header = "From:" . SENDER_EMAIL_ADDRESS;

    // send the email
    mail($email, $subject, nl2br($message), $header);

}

function register_user(string $email, string $activation_code, int $expiry = 1 * 24  * 60 * 60): bool
{
	global $pdo;
	$sql = 'insert into system_users

                    (

                    username,

		    activation_code,

		    activation_expire

                    )

                    values

                    (

                    :username,

                    :activation_code,

		    :activation_expire

                    )                       

                    '; 

	$data = [];

	$retour = false;

        $data = [

                    'username'   => $email,

                    'activation_code' => $activation_code,
                    //'activation_code' => password_hash($activation_code, PASSWORD_DEFAULT),

                    'activation_expire' => date('Y-m-d H:i:s',  time() + $expiry)

                    ];
	
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            		$stmt = $pdo->prepare($sql);

            		$retour = $stmt->execute($data); 
	}

	return $retour;

}

function find_unverified_user($activation_code, $email)
{
	global $pdo;
	$sql = 'select
		    user_id, activation_code, activation_expire < now() as expired
                    from system_users
                    where username = :username                        
                    '; 
            $data = [];
            $data = [
                    	'username' => $email
                    ];
            $stmt = $pdo->prepare($sql);
            $stmt->execute($data);     
	    $user_data = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {         
                $user_data = $row;          
            }                 
	    if ((int)$user_data['expired'] === 1) {
        	    delete_user_by_id($user_data['user_id']);
            	    return null;
             } else {
            	if (strcmp($activation_code, $user_data['activation_code']) == 0) {	    
			return true;
	   	} else {
			return false;
	   	}
             }
}

function delete_user_by_id($id)
{
	global $pdo;
	$sql = 'delete from system_users where user_id=:id';
	$data = [];
	$data = [ 'id' => $id ];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
}

function delete_user_by_username($id)
{
	global $pdo;
	$sql = 'delete from system_users where username=:id';
	$data = [];
	$data = [ 'id' => $id ];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
}

function find_user_by_username($email)
{
	global $pdo;
	$sql = 'select user_id from system_users where username=:id limit 1';
	$data = [];
	$data = [ 'id' => $email ];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
	$user_data = [];
	$count = $stmt->rowCount();
	if ($count>0) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {         
			$user_data = $row;          
		}                 
		$retour=$user_data['user_id'];
	} else {
		$retour='-1';
	}
	return $retour;	
}

function find_user_by_id($id)
{
	global $pdo;
	$sql = 'select user_id from system_users where user_id=:id limit 1';
	$data = [];
	$data = [ 'id' => $id ];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
	$user_data = [];
	$count = $stmt->rowCount();
	if ($count>0) {
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {         
			$user_data = $row;          
		}                 
	} else {
		$retour='-1';
	}
	return $retour;
}

function delete_activation_code($username,$activation)
{
	global $pdo;
	$sql = "update system_users set activation_code=:hasard where username=:username and activation_code=:activation";
	$data = [];
	$data = [
		'hasard' => generate_activation_code(),
		'username' => $username,
		'activation' => $activation
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
}
function change_activation_code($username,$activation)
{
	global $pdo;
	$sql = "update system_users set activation_code=:hasard where username=:username";
	$data = [];
	$data = [
		'hasard' => $activation,
		'username' => $username
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
}
?>
