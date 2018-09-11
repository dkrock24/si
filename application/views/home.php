
<?php include_once "template/main.php";?>

<?php
	foreach ($user as  $value) {
		echo $value->nickname;
	}
?>

<?php include_once "template/footer.php"; ?>