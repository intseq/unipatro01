<?php
include_once('./config.php');

$mb_id =  get_session("usr_id");

echo "mb_id".$mb_id;
if($mb_id){
?>
	<a href="logout.php">logout</a>
<?php
}else{
?>

<form action="login.sql.php" name='login'>
	<input type="text" name='usr_id' />
	<input type="text" name='usr_pw' />
	<button>login</button>
</form>
<?php
}
?>

