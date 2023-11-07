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
	$sql="delete from videos_comments where comment_videolink=:v_id and comment_id=:c_id";
	//$sql="delete from videos_comments where comment_videolink=:v_id and comment_id=:c_id and comment_owner=:c_owner";
	$data = [];
	$data = [
		"v_id" => $v_id,
		"c_id" => $c_id
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);	
}

function video_comments_delete_all($v_id)
{
	global $pdo;
	$sql="delete from videos_comments where comment_videolink=:v_id";
	$data = [];
	$data = [
		"v_id" => $v_id
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);	
}

function video_comments_get($c_id)
{
	global $pdo;
	$sql="select comment_value from videos_comments where comment_id=:c_id";
	$data = [];
	$data = [
		"c_id" => $c_id
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);	
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	return($row['comment_value']);
}

function video_comments_modify($c_id, $c_value)
{
	global $pdo;
	$sql="update videos_comments set comment_value=:c_value where comment_id=:c_id";
	$data = [];
	$data = [
		"c_id" => $c_id,
		"c_value" => $c_value
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);	
}
function video_insert_link($m_id,$a_id,$u_id,$v_url,$v_name)
{
	global $pdo;
	$sql="insert into videos (meeting_id, agendum_id, video_owner, video_link, video_name) values (:m_id,:a_id,:u_id,:v_url,:v_name)";
	$data = [];
	$data = [
		"m_id" => $m_id,
		"a_id" => $a_id,
		"u_id" => $u_id,
		"v_url" => $v_url,
		"v_name" => $v_name
	];
	$stmt = $pdo->prepare($sql);
        $stmt->execute($data);
}
function video_delete($v_id,$u_id)
{
	global $pdo;
	$sql="delete from videos where video_id=:v_id and video_owner=:u_id";
	$data = [];
	$data = [
		"v_id" => $v_id,
		"u_id" => $u_id
	];
	$stmt = $pdo->prepare($sql);
        $stmt->execute($data);
}
?>
