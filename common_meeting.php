<?php
function meeting_exist($m_owner,$m_name)
{
	global $pdo;
	$sql="select meeting_id from meetings where meeting_name=:mname and meeting_owner=:mowner";
	$data = [];
	$data = [
		'mname' => $m_name,
		'mowner' => $m_owner
	];	
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
	$user_data = [];
	$count = $stmt->rowCount();
	if ($count>0) {
		$user_data = $stmt->fetchAll();
		return $user_data[0];
	} elseif ($count==0) {
		return false;
	} else {
		return -1;
	}
}

function meeting_create($m_owner,$m_name)
{
	global $pdo;
	$sql="insert into meetings (meeting_name, meeting_owner) values (:mname,:mowner)";
	$data = [];
	$data = [
		'mname' => $m_name,
		'mowner' => $m_owner
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
}

function meeting_delete($m_owner,$m_name)
{
	global $pdo;
	$sql="delete from meetings where meeting_name=:mname and meeting_owner=:mowner";
	$data = [];
	$data = [
		'mname' => $m_name,
		'mowner' => $m_owner
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
}

function meeting_rename($m_owner,$m_name, $m_oldname)
{
	global $pdo;
	$sql="update meetings set meeting_name=:moldname where meeting_name=:mname and meeting_owner=:mowner";
	$data = [];
	$data = [
		'mname' => $m_name,
		'moldname' => $m_oldname,
		'mowner' => $m_owner
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
}

function meeting_list($m_owner)
{
	global $pdo;
	$sql="select meeting_id, meeting_name from meetings where meeting_owner=:mowner limit 100";
	$data = [];
	$data = [
		'mowner' => $m_owner
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
function meeting_list_by_role($user_id, $role_id)
{
	global $pdo;
	$sql="select a.meeting_id, meeting_name from meetings a, meeting_roles_by_users b where a.meeting_id=b.meeting_id and b.user_id=:u_id and b.m_role_id=:r_id";
	$data = [];
	$data = [
		'u_id' => $user_id,
		'r_id' => $role_id
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
function meeting_create_agendum($m_id,$value,$isdef=0)
{
	global $pdo;
	$sql="insert into agendum (meeting_id, agendum_label, is_default) values (:mid,:mlabel,:isdef) ";
	$data = [];
	$data = [
		'mid' => $m_id,
		'mlabel' => $value,
		'isdef' => $isdef
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
}
function meeting_create_participants($m_id,$value,$role)
{
	global $pdo;
	$sql="insert into participants (meeting_id, participant_id, role_id ) values (:mid,:mpart,:mrole) ";
	$data = [];
	$data = [
		'mid' => $m_id,
		'mpart' => $value,
		'mrole' => $role
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
}
function meeting_invite_participants($m_id,$value,$role)
{
	global $pdo;
	$sql="insert into participants_invite (meeting_id, participant_email, role_id ) values (:mid,:mpart,:mrole) ";
	$rarr=["R"=>0,"A"=>1,"C"=>2,"I"=>3];
	$rrole=$rarr[$role];
	$data = [];
	$data = [
		'mid' => $m_id,
		'mpart' => $value,
		'mrole' => $rrole
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
}
function meeting_list_by_invitation($u_email)
{
	global $pdo;
	$sql="select a.meeting_id, meeting_name, role_id from meetings a, participants_invite b where a.meeting_id=b.meeting_id and participant_email=:u_email";
	$data = [];
	$data = [
		'u_email' => $u_email
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
function meeting_list_participants($m_id)
{
	global $pdo;
	$sql="select user_id from meeting_roles_by_users where meeting_id=:m_id";
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
function meeting_list_participants_by_mail($m_id)
{
	global $pdo;
	$sql="select a.user_id, username from meeting_roles_by_users a, system_users b where meeting_id=:m_id and a.user_id=b.user_id";
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
function meeting_is_participant($m_id, $u_id)
{
	global $pdo;
	$sql="select user_id from meeting_roles_by_users where meeting_id=:m_id and user_id=:u_id";
	$data = [];
	$data = [
		'm_id' => $m_id,
		'u_id' => $u_id
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
	$count = $stmt->rowCount();
	$user_data = [];
	if ($count>0) {
		return true;
	} else {
		return false;
	}

}
function meeting_add_participants($m_id,$u_id,$r_id)
{
	global $pdo;
	$sql="insert into meeting_roles_by_users(meeting_id, user_id, m_role_id) values (:m_id,:u_id,:r_id)";
	$data = [];
	$data = [
		'm_id' => $m_id,
		'u_id' => $u_id,
		'r_id' => $r_id	
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
}
function meeting_del_participants($m_id,$u_id)
{
	global $pdo;
	$sql="delete from meeting_roles_by_users where meeting_id=:m_id and user_id=:u_id";
	$data = [];
	$data = [
		'm_id' => $m_id,
		'u_id' => $u_id
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
}
function meeting_invite_remove($m_id,$u_mail)
{
	global $pdo;
	$sql="delete from participants_invite where meeting_id=:m_id and participant_email=:u_mail";
	$data = [];
	$data = [
		'm_id' => $m_id,
		'u_mail' => $u_mail
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
}
function meeting_get_name($m_id)
{
	global $pdo;
	$sql="select meeting_name from meetings where meeting_id=:m_id";
	$data = [];
	$data = [
		"m_id" => $m_id
	];
	$stmt = $pdo->prepare($sql);
	$stmt->execute($data);
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	return($row['meeting_name']);	
}
?>
