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



            $sql = 'insert into system_users

                    (

                    username,

                    first_name,

                    last_name,

                    pwd

                    )

                    values

                    (

                    :username,

                    :first_name,

                    :last_name,

                    :pwd

                    )                       

                    '; 



            $data = [];



            $data = [

                    'username'   => $_POST['username'],

                    'first_name' => $_POST['first_name'],

                    'last_name'  => $_POST['last_name'],

                    'pwd'        => password_hash($_POST['pwd'], PASSWORD_BCRYPT)             

                    ];


	if (filter_var($_POST['username'], FILTER_VALIDATE_EMAIL)) {
		if (check_pwd($_POST['pwd']))
		{
            		$stmt = $pdo->prepare($sql);

            		$stmt->execute($data); 

            		echo "User data saved successfully.\n" ;
		} else {
			echo "password not strength";	
		}
	} else {
		echo "invalid mail format";
	}



        } catch (PDOException $e) {

            echo 'Database error. ' . $e->getMessage();

        }
