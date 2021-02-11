<?php
include_once "hjelpefunksjoner.php";
$dblink = topp();
if(!empty($_POST['brukernavn']) && !empty($_POST['passord']) && !empty($_POST['epost']))
{
    $brukernavn = mysql_real_escape_string($_POST['brukernavn']);
    $passord = md5(mysql_real_escape_string($_POST['passord']));
    $epost = mysql_real_escape_string($_POST['epost']);
     
     $checkusername = mysqli_query($dblink, "SELECT * FROM bruker WHERE brukernavn = '".$brukernavn."'");

     if(mysqli_num_rows($checkusername) == 1)
     {
        echo "<h1>Error</h1>";
        echo "<p>Brukernavn ikke gyldig, vennligst velg annen brukernavn.</p>";
     }
     else
     {
        $registerquery = mysqli_query($dblink, "INSERT INTO bruker (brukernavn, passord, epost, dato, erAdmin) VALUES('".$brukernavn."', '".$passord."', '".$epost."', NOW(), false)");
        if($registerquery)
        {
            echo "<h1>Suksess</h1>";
            echo "<p>Bruker Opprettet  <a href=\"logginn.php\">Logg inn her</a>.</p>";
        }
        else
        {
            echo "<h1>Error</h1>";
            echo "<p> Registrering mislykket, vennligst prøv igjen.</p>";    
        }       
     }
}
// Kanskje unødvendig.
else if(isset($_SESSION['brukernavn'])){
    echo "<p>Du har allerede en konto.</p>";
}
else
{

    ?>
     
   <h1>Register</h1>
     

   <p> Vennligst skriv ned detaljer for registrering.</p>
     
    <form method="post" action=""> 
    
	<table border ="0" width = "50%">
	<tr>
	<td>Epost:</td>
	<td> <input type = "email" name ="epost" size ="40" required></td>
	</tr>
	<tr>
	<td>Brukernavn:</td>
	<td> <input type = "text" name ="brukernavn" size ="40" required></td>
	</tr>
	<tr>
	<td>Passord: </td>
	<td><input type ="password" name="passord" size = "15" required></td>
	</tr>
	</table>
	<p>
  	<input type="submit" value="Lag bruker" name="sendKnapp">
  	<input type="reset" value="Rensk skjema" name="renskKnapp">
	</p>
    </form>
     
    <?php
}
bunn($dblink);
?>