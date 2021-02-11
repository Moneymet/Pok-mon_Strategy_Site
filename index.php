<?php
include_once "hjelpefunksjoner.php";

$MAKS_PER_SIDE = 5;
$dblink = topp();
if(isset($_POST['slettetStrategi'])){
	mysqli_query($dblink, "DELETE FROM strategi WHERE idStrategi = {$_POST['slettetStrategi']}");
}
echo "<h1>Nylige strategier:</h1>";
$sql = "CALL sisteStrategier(@tekst,@brukernavn,@stratid)";
$resultat = mysqli_query($dblink, $sql);
if($resultat){
$rad = mysqli_fetch_assoc($resultat);
	for($i = 0; $rad && $i <$MAKS_PER_SIDE; $i++){
		strategiBoks($rad['strategiTekst'], $rad['brukernavn'], $rad['idStrategi']);
		$rad = mysqli_fetch_assoc($resultat);
	}
} else{
	echo "<p>Ingen strategier tilgjenglig.</p>";
}

echo mysql_error();

bunn($dblink);
?>