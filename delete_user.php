<?php
session_start();
error_reporting(E_ALL);
include('lib/cryptography.php');
include('lib/config.php');
$user_id = $_GET['biodata'];
$user_id = htmlentities(encrypt_decrypt($user_id, 'decrypt'));
$sql = $con->prepare("DELETE FROM biodata WHERE user = :user_id");
$sql->bindParam(':user_id', $user_id, PDO::PARAM_STR);
if ($sql->execute()) {
	?>
	<script type="text/javascript">alert('Bio data deleted!'); window.close();</script>
	<?php
}
else {
	?>
	<script type="text/javascript">alert('Failed to delete Bio data!'); window.close();</script>
	<?php
}
?>