<?php

// Viktig at DB er navnet på database-samlingen?
define("TJENER","localhost");
define("BRUKER","root");
define("PASSORD","");
define("DB","pokemon");

function kobleOpp(){
	$dblink=mysqli_connect(TJENER,BRUKER,PASSORD,DB);
	if(!$dblink){
		echo mysqli_connect_error();
		die('klarte ikke å koble til databasen:' . mysqli_error($dblink));
	}
	mysqli_set_charset($dblink,'utf8');
	return $dblink;
}

function lukk($dblink){
	mysqli_close($dblink);
}

function gyldigBruker($dblink,$brukernavn,$passord){
	$ok = false;
	$_SESSION['innlogget'] = false;
	$sql ="SELECT * FROM bruker WHERE brukernavn='$brukernavn'";
	$resultat= mysqli_query($dblink, $sql);
	$antall = mysqli_num_rows($resultat);
	if($antall == 1) {
		$rad = mysqli_fetch_assoc($resultat);
		$kryptert = $rad['passord'];
		echo $rad['brukernavn'];

		if( md5($passord) == $kryptert){
			$ok = true;
		
			$_SESSION['idBruker'] = $rad['idBruker'];
      		$_SESSION['brukernavn'] = $rad['brukernavn'];
      		$_SESSION['epost'] = $rad['epost'];
      		$_SESSION['innlogget'] = true;
      		$_SESSION['erAdmin'] = $rad['erAdmin'];
		}
	}
	return $ok;
} 

function loggUt(){
	session_destroy();
}



function sjekkInnlogging() {
  if (!isset($_SESSION['epost'])) {
    session_destroy();
    header("");
  }
}


?>