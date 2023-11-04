<?php
$user = "usr_asyncmeeting";
$password = "aze123QSD!";
$database = "asyncmeeting";
$table = "videocomments";

function getStringBetween($str,$from,$to, $withFromAndTo = false)
    {
       $sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
       if ($withFromAndTo)
         return $from . substr($sub,0, strrpos($sub,$to)) . $to;
       else
         return substr($sub,0, strrpos($sub,$to));
    }


try {
     $db = new PDO("mysql:host=localhost;dbname=$database", $user, $password);

        $comment_video=$_POST["VideoName"];
        foreach ( $_POST['pets'] as $value )
        {
            $enr=explode(':',$value);
            $enr_time = getStringBetween($enr[0], '[', ']');
            $enr_comment = $enr[1];
            echo "insert into videocomments (comment_videolink, comment_time, comment_value) values ('$comment_video','$enr_time','$enr_comment')";
            $db->query("insert into $table (comment_videolink, comment_time, comment_value) values ('$comment_video','$enr_time','$enr_comment')");
            echo "<br>";
        }
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
echo $comment_video;
?>
