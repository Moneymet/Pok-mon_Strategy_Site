<?php

include_once "hjelpefunksjoner.php";

$dblink = topp();

if(isset($_POST['nyStrategiTekst']) && isset($_SESSION['brukernavn'])){
	/*sql magic*/
	$resultat = mysqli_query($dblink, "SELECT idBruker from bruker WHERE brukernavn = '{$_SESSION['brukernavn']}'");
	$brukerid = mysqli_fetch_assoc($resultat);

	$trenernavn =  mysqli_real_escape_string($dblink, $_GET['trener']);

	$resultat = mysqli_query($dblink, "SELECT idTrener from trener WHERE trenernavn = '{$trenernavn}'");
	$trenerid = mysqli_fetch_assoc($resultat);

	$sql = "INSERT INTO strategi(strategiTekst, score, Bruker_idBruker, Trener_idTrener, dato)
			VALUES ('{$_POST['nyStrategiTekst']}', 0, {$brukerid['idBruker']}, {$trenerid['idTrener']}, NOW())";
	mysqli_query($dblink, $sql);
	echo "<p>Strategien er sendt inn.</p>";
}
else if(isset($_GET['trener'])){
	echo "<p>{$_GET['trener']}</p>
		<form method = \"POST\">
			<textarea id = \"nyStrategiTekst\" name = nyStrategiTekst></textarea>
			<input type = \"submit\">
		</form>";
}else{
	echo "<a href = \"trenere.php\"><p>Velg trener for strategi.</p></a>";
}

bunn($dblink);

?>