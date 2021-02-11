<?php

include_once "hjelpefunksjoner.php";

$dblink = topp();

$MAKS_PER_SIDE = 5;

if(isset($_POST['slettetStrategi'])){
	mysqli_query($dblink, "DELETE FROM strategi WHERE idStrategi = {$_POST['slettetStrategi']}");
}

if(isset($_GET['trener'])){

	echo "<form method = \"GET\" action = \"nystrategi.php\">
			<input type = \"hidden\" name = \"trener\" value = \"{$_GET['trener']}\">
			<input type = \"submit\" value = \"Lag ny strategi\">
		</form>";

	echo "<table>
			<tr><td>";
	

	
	$elementer = 0;
	if(isset($_GET['elementer'])){
		$elementer = $_GET['elementer'];
	}
	$sql = "SELECT trenernavn, strategiTekst, brukernavn, idStrategi FROM strategi JOIN trener ON strategi.Trener_idTrener = trener.idTrener JOIN bruker ON strategi.Bruker_idBruker = bruker.idbruker WHERE trenernavn = '" . $_GET['trener'] . "' ORDER BY 'score' LIMIT $elementer, $MAKS_PER_SIDE";
	$resultat = mysqli_query($dblink, $sql);
	$antall = mysqli_num_rows($resultat);
	for($i = 0; $i < $antall && $i < $MAKS_PER_SIDE; $i++){
		$rad = mysqli_fetch_assoc($resultat);
		strategiBoks($rad['strategiTekst'], $rad['brukernavn'], $rad['idStrategi']);
	}
	$holdTrener = "<input type = \"hidden\" name = \"trener\" value = {$_GET['trener']}>";
	$antallVenstre = 0;
	if($elementer-$MAKS_PER_SIDE > 0){
		$antallVenstre = $elementer - $MAKS_PER_SIDE;
	}
	if($elementer > 0){
		echo "<form method=\"GET\">
				<input type = \"hidden\" name = \"elementer\" value = $antallVenstre>
				$holdTrener
				<input type = \"submit\" value = \"Tilbake\">
			</form>";
	}

	$antallHøyre = $antall;
	if($elementer+$MAKS_PER_SIDE < $antall){
		$antallHøyre = $elementer + $MAKS_PER_SIDE;
	}
	if($elementer < $antall){
	echo "<form method=\"GET\" >
			<input type = \"hidden\" name = \"elementer\" value = $antallHøyre>
			$holdTrener
			<input type = \"submit\" value = \"Neste\">
		</form>";
	}
	


	echo "</td><td>";
	trenerBoks($dblink, "{$_GET['trener']}");

	echo "	</td></tr>
		</table>";
}
else{
	echo "<p><a href=\"trenere.php\">Velg trener her.</a></p>";
}
bunn($dblink);

?>