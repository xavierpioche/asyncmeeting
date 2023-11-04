<?php
function getStringBetween($str,$from,$to, $withFromAndTo = false)
{
  $sub = substr($str, strpos($str,$from)+strlen($from),strlen($str));
  if ($withFromAndTo)
         return $from . substr($sub,0, strrpos($sub,$to)) . $to;
   else
         return substr($sub,0, strrpos($sub,$to));
}

function video_comments_save($v_id, $v_time, $v_comment)
{
	global $pdo;
	$sql="insert into videos_comments (comment_videolink, comment_time, comment_value) values (:v_id,:v_time,:v_comment)";
	$data = [];
	$data = [
		'v_id' => $v_id,
		'v_time' => $v_time,
		'v_comment' => $v_comment
	];
	$stmt = $pdo->prepare($sql);
        $stmt->execute($data);
}

function video_comments_list($v_id)
{
	global $pdo;
	$sql="select comment_id, comment_time, comment_value from videos_comments where comment_videolink=:v_id order by comment_time";
	$data = [];
	$data = [
		"v_id" => $v_id
	];
	$stmt = $pdo->prepare($sql);
        $stmt->execute($data);
	$count=$stmt->rowCount();
	$user_data = [];
	if ($count>0) {
		$user_data = $stmt->fetchAll();
		return $user_data;
	} else {
		return [];
	}
}

function video_comments_delete($v_id, $c_id)
{
	global $pdo;
}

function video_comments_modify($v_id, $c_id, $c_comment)
{
	global $pdo;
}
?>
