
<?php
include_once "hjelpefunksjoner.php";
$innlogget = false;
$dblink = topp();
if(!isset($_SESSION['brukernavn'])){
?>
	<form method="POST" action="">
	<table border ="0" width = "50%">
		<tr>
		<td><p class = "labelTekst">Brukernavn</p></td>
		<td> <input type = "text" name ="brukernavn" size ="40" required></td>
	</tr>
	<tr>
	<td><p class = "labelTekst">Passord: </p></td>
	<td><input type ="password" name="passord" size = "15" required></td>
	</tr>
	</table>

<?php
} else {
	echo "<p>Du er allerede logget inn.</p>";
}
if (isset($_POST["brukernavn"]) &&($_POST["passord"]) && !isset($_SESSION['brukernavn'])){

	$brukernavn = mysqli_real_escape_string($dblink, $_POST['brukernavn']);
	$passord = mysqli_real_escape_string($dblink, $_POST['passord']);
	if(gyldigBruker($dblink, $brukernavn, $passord)){
		echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\" />";
	}
	else { 
		echo "<p>Feil brukernavn eller passord.</p>";

	}

}
if(!isset($_SESSION['brukernavn'])){
?>
<p>
	  <input type="submit" value="Logg inn" name="sendKnapp">
	  <input type="reset" value="Rensk skjema" name="renskKnapp">
</p>
<p> Hvis du ikke er bruker så vennligst registrer deg <a href="nybruker.php">her.</a></p>
</form>

<?php
}
bunn($dblink);

?>