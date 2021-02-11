<?php

include_once "hjelpefunksjoner.php";

$dblink = topp();

$MAKS_PER_SIDE = 5;
// Kommer fra strategiBoks fra hjelpefunksjoner.
if(isset($_POST['slettetStrategi'])){
	mysqli_query($dblink, "DELETE FROM strategi WHERE idStrategi = {$_POST['slettetStrategi']}");
}
if(isset($_POST['slettetBruker'])){
	$brukernavn = $_POST['slettetBruker'];
	$sql = "SELECT idBruker FROM bruker WHERE brukernavn = '{$brukernavn}'";
	$resultat = mysqli_query($dblink, $sql);
	$rad = mysqli_fetch_assoc($resultat);
	$brukerid = $rad['idBruker'];
	$sql = "DELETE FROM strategi WHERE Bruker_idBruker = '{$brukerid}';
			DELETE FROM har_stemt WHERE Bruker_idBruker = '{$brukerid}';
			DELETE FROM bruker WHERE idBruker = '{$brukerid}'";
	mysqli_multi_query($dblink, $sql);
	echo "<meta http-equiv=\"refresh\" content=\"0; url=loggut.php\" />";
}

if(isset($_GET['brukernavn'])){
	$brukernavn = $_GET['brukernavn'];
	echo "<h1 style = \"display:inline-block\">$brukernavn</h1>";
	if(isset($_SESSION['brukernavn']) && isset($_SESSION['erAdmin'])){
		if($_SESSION['brukernavn'] == $brukernavn || $_SESSION['erAdmin']){
			echo "<form method = \"POST\" style = \"display:inline-block; margin: 10px\">
					<input type = \"hidden\" name = \"slettetBruker\" value = \"{$brukernavn}\">
					<input type=\"submit\" value = \"Slett bruker\">
				</form>";
		}
	}

	$sql = "SELECT strategiTekst, brukernavn, idStrategi FROM strategi JOIN bruker ON strategi.Bruker_idBruker = bruker.idBruker WHERE bruker.brukernavn = '{$brukernavn}'
			ORDER BY strategi.dato";
	$resultat = mysqli_query($dblink, $sql);
	$antall = mysqli_num_rows($resultat);
	for($i = 0; $i < $antall && $i < $MAKS_PER_SIDE; $i++){
		$rad = mysqli_fetch_assoc($resultat);
		strategiBoks($rad['strategiTekst'], $rad['brukernavn'], $rad['idStrategi']);
	}
}

bunn($dblink);
?>