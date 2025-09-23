<?php
error_reporting(E_ALL);
require('lib/config.php');
$state = $_POST["state"];
$query = $con->prepare("SELECT * FROM ng_lga WHERE state_id = :state ORDER BY lga_name");
$query->bindParam(":state", $state, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);
if ($query->rowCount() > 0) {
	?>
	<option selected disabled>Select L.G.A</option>
	<?php
	foreach ($results as $result) {
		?>
		<option value="<?php echo($result->id); ?>"><?php echo($result->lga_name); ?></option>
		<?php
	}
}
