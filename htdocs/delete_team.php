<?php
	include 'universal.php';
	if (!isset($_SESSION['validID'])){
		header('Location: index.php');
		exit;
	}
	

	$delete = "DELETE FROM Team WHERE Name = :tmdlt";
	$output = 'Trying to delete ';
	foreach ($_POST['delete_team'] as $var) {
		try {
			$pdodt->beginTransaction();
			  $tds = $pdodt->prepare($delete);
			  $tds->bindParam(':tmdlt', $var);
			  $tds->execute();
			  $pdodt->commit();
			$output .= $var.', ';
		} catch (Exception $e) {
			$pdodt->rollBack();
			echo "Failed: ".$e->getMessage();
		}
	}

	echo $output;

?>
