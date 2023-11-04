<?php
function agendum_list_by_meeting($m_id)
{
	global $pdo;
	$sql="select agendum_id, agendum_label from agendum where meeting_id=:m_id";
	$data = [];
	$data = [
		'm_id' => $m_id
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
	$count = $stmt->rowCount();
	$user_data = [];
	if ($count>0) {
		$user_data = $stmt->fetchAll();
		return $user_data;
	} else {
		return [];
	}
}
function agendum_add_in_meeting($m_id,$a_label)
{
	global $pdo;
	$sql="insert into agendum (meeting_id, agendum_label) values (:m_id, :a_label)";
	$data = [];
	$data = [
		'm_id' => $m_id,
		'a_label' => $a_label
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
}
function agendum_del_in_meeting($m_id,$a_id)
{
	global $pdo;
	$sql="delete from agendum where meeting_id=:m_id and agendum_id=:a_id";
	$data = [];
	$data = [
		'm_id' => $m_id,
		'a_id' => $a_id
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
}
function agendum_mod_name($a_id,$a_label)
{
	global $pdo;
	$sql="update agendum set agendum_label=:a_label where agendum_id=:a_id";
	$data = [];
	$data = [
		'a_label' => $a_label,
		'a_id' => $a_id
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
}
function agendum_verify_meeting($m_id,$a_id)
{
	global $pdo;
	$sql="select agendum_id from agendum where meeting_id=:m_id and agendum_id=:a_id";
	$data = [];
	$data = [
		'm_id' => $m_id,
		'a_id' => $a_id
	];
	$stmt = $pdo->prepare($sql);
        $stmt->execute($data);
	$count = $stmt->rowCount();
	if ($count==1) {
		return true;
	} else {
		return false;
	}
}
function agendum_get_default($m_id)
{
	global $pdo;
	$sql="select agendum_id from agendum where meeting_id=:m_id and is_default=1";
	$data = [];
	$data = [
		"m_id" => $m_id
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
	$count = $stmt->rowCount();
	if($count==0) {
		return -1;
	} else {
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		return $row['agendum_id'];		
	}
}
function agendum_get_videos($a_id, $v_id=NULL)
{
	global $pdo;
	$data = [];
	if(is_null($v_id))
	{
		$sql="select video_id, video_link, video_name from videos where agendum_id=:a_id order by is_default desc";
		$data = [
			"a_id" => $a_id
		];
	} else {
		$sql="select video_id, video_link, video_name from videos where agendum_id=:a_id and video_id=:v_id";
		$data = [
			"a_id" => $a_id,
			"v_id" => $v_id
		];
	}
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
function agendum_get_my_meeting($a_id)
{
	global $pdo;
	$sql="select meeting_id from agendum where agendum_id=:a_id";
	$data = [];
	$data = [
		"a_id" => $a_id
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
	$count=$stmt->rowCount();
	if($count>0) {
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		return $row['meeting_id'];
	} else {
		return -1;
	}
}
function agendum_get_name($a_id)
{
        global $pdo;
        $sql="select agendum_label from agendum where agendum_id=:a_id";
        $data = [];
        $data = [
                "a_id" => $a_id
        ];
        $stmt = $pdo->prepare($sql);
        $stmt->execute($data);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return($row['agendum_label']);
}
?>
