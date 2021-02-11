<?php 

	include_once "kobling.php";

	if(isset($_POST['spill'])){
		$dblink = kobleOpp();
		$spill = $_POST['spill'];
		$sql = "SELECT trenernavn from trener JOIN spill ON trener.Spill_idSpill = spill.idSpill
		 WHERE '{$spill}' = spill.spillnavn";
		 echo $sql;
		//$sql = "SELECT * from spill";
		$resultat = mysqli_query($dblink, $sql);
		while($rad = mysqli_fetch_assoc($resultat)){
			echo "<option value=\"{$rad['trenernavn']}\" >{$rad['trenernavn']}</option>";
		}
		//echo "<option>{$_POST['spill']}</option>";

		lukk($dblink);
	}
?>