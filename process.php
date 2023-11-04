<?php 
include('config/globals.php');

    try {

            $db_name     = $database;

            $db_user     = $user;

            $db_password = $password;

            $pdo = new PDO('mysql:host=' . $db_host . '; dbname=' . $db_name, $db_user, $db_password);

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  

            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 



            $sql = 'select

                    user_id,

                    username,

                    first_name,

                    last_name,

                    pwd                                 

                    from system_users

                    where username = :username                        

                    '; 



            $data = [];

            $data = [

                    	'username' => $_POST['username']

                    ];



            $stmt = $pdo->prepare($sql);

            $stmt->execute($data);               



            $user_data = [];



            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {         

                $user_data = $row;          

            }                 



            if (password_verify($_POST['pwd'], $user_data['pwd']) == true) {

                $session_token      = bin2hex(openssl_random_pseudo_bytes(16));

                $user_data['token'] = $session_token;



                setcookie('token', $session_token, time()+3600);

                setcookie('username', $user_data['username'], time()+3600);


                $redis = new Redis(); 

                $redis->connect($redis_db, $redis_port);

                $redis_key =  $user_data['username'];



                $redis->set($redis_key, serialize($user_data)); 

                $redis->expire($redis_key, 3600);                  



                header('Location: dashboard.php');

            } else {

                header('Location: signin.php');

            }               



        } catch (PDOException $e) {

            echo 'Database error. ' . $e->getMessage();

        }
