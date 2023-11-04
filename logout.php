<?php
include 'config/globals.php'; 
$redis = new Redis(); 
$redis->connect($redis_db, $redis_port);
$redis_key =  $_COOKIE['username'];
$redis->delete($redis_key);

setcookie($_COOKIE['token'],NULL, time()-3600);
setcookie($_COOKIE['username'],NULL, time()-3600);
session_unset();
session_destroy();
?>
