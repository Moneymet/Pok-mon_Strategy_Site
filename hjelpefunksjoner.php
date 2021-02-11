<?php 

include_once "kobling.php";

function topp(){
    $dblink = kobleOpp();
    session_start();
	echo "<!DOCTYPE html>
    <html>
    <head>
    <title>Pokémonstrategi</title>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"fellesstil.css\" />
    <meta charset=\"UTF-8\" />
    <script src = \"jsFunksjoner.js\"></script>
    <body>
    <div id=toppSeksjon>
        <h1 id=logoTekst><a href=\"index.php\">Pokémon-strategier</a></h1>
        <div id=loggInnTekst>";
        if(isset($_SESSION['brukernavn'])){
            echo "<form action=\"loggut.php\" id = \"loggUtKnapp\">
                    <input type=\"submit\" value=\"Logg ut\">
                 </form>";
            echo "<p class = \"labelTekst\"><a href=bruker.php?brukernavn={$_SESSION['brukernavn']} style =\"float:right\">" . $_SESSION['brukernavn'] . "</a></p>";
            
        } 
        else 
            echo "<p class = \"labelTekst\"><a href=logginn.php>Logg inn</a> eller <a href=nybruker.php>lag ny bruker.</a></p>";
        echo "</div>";
    echo "</div>
    <div id=hovedMeny>
        <p class = \"labelTekst\"><a href=\"index.php\" class=\"menyKnapp\">Forside</a></p>
        <p class = \"labelTekst\"><a href=\"trenere.php\" class=\"menyKnapp\">Trenere</a></p>
        <p class = \"labelTekst\"><a href=\"strategier.php\" class=\"menyKnapp\">Strategier</a></p>
        <p class = \"labelTekst\"><a href=\"nystrategi.php\" class=\"menyKnapp\">Ny strategi</a></p>
    </div>
    <div id=hovedInnhold>
    ";
    return $dblink;
}

function bunn($dblink){
	echo "
    </div>
    <hr/>
    <p>
    <a href=\"mailto:christergum@hotmail.com\">Klag her</a>
    </p>
    </body>
    </html>";
    lukk($dblink);
}

function strategiBoks($tekst, $navn, $stratid){
    $erAdmin = (isset($_SESSION['erAdmin']) ? $_SESSION['erAdmin'] : false);
    echo "<div class=\"strategiBoksCSS\"><p>$tekst</p>";
    echo "<a href=\"bruker.php?brukernavn=$navn\" ><p style=\"display:inline-block\">$navn</p></a>";
    if(isset($_SESSION['brukernavn'])){
        if($_SESSION['brukernavn'] == $navn || $erAdmin){
            echo "<form method = \"POST\" style = \"display:inline; margin-left: 10px;\">
                    <input type = \"hidden\" name = \"slettetStrategi\" value = \"{$stratid}\">
                    <input type = \"submit\" value = \"Slett\">
                </form>";
        }
    }
    echo "</div><br>";
}

function trenerBoks($dblink, $navn){
    echo "<div class=\"trenerBoksCSS\">";
    echo "<p style = \"text-align:center\">$navn</p>";
    $sql = "SELECT navn, Move_1, Move_2, Move_3, Move_4, Hold_Item FROM trener JOIN
             trenerspokemon ON trener.idTrener = trenerspokemon.Trener_idTrener
             JOIN pokemon ON trenerspokemon.Pokemon_idPokemon = pokemon.idPokemon
             WHERE trener.idTrener = trenerspokemon.Trener_idTrener AND trener.trenernavn = '{$navn}'";
    $resultat = mysqli_query($dblink, $sql);
    $rad = mysqli_fetch_assoc($resultat);
    $perRad = 2;
    echo "<table border = 1 style = \"width:100%;background-color: #eef;\">";
    while($rad){
        echo "<tr>";
        for($i = 0; $rad && $i < $perRad; $i++){
            echo "<td>";
            echo "<p style = \"text-align:center\">{$rad['navn']}</p>";
            echo "<table border = 1 style = \"width:100%\"><tr>
                            <td> <p>{$rad['Move_1']}.</p>
                            </td>
                            <td> <p>{$rad['Move_2']}.</p>
                            </td>
                        </tr>
                        <tr>
                            <td> <p>{$rad['Move_3']}.</p>
                            </td>
                            <td> <p>{$rad['Move_4']}.</p>
                            </td>
                        <tr>
                        </table>";
            echo "</td>";
            $rad = mysqli_fetch_assoc($resultat);
        }
        echo "</tr>";
    }
    echo "</td></tr></table></div><br>";
}

?>