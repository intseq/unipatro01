<?php
	include_once('./config.php');
	$sql = "select * from usr where usr_id='$usr_id' and usr_pw = '$usr_pw'";
	$ro=sql_fetch($sql);
	if ($ro){
		set_session('usr_id',$ro['usr_id']);
		goto_url('/login.php');
	}else{
		echo "no member";
		alert('회원이 아닙니다.');
	}
?>

