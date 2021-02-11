<?php

include_once "hjelpefunksjoner.php";

$dblink = topp();
echo "<form method = \"GET\" action = \"strategier.php\">
		<table border =\"0\" width = \"25%\">
			<tr>
				<td>
					<p>Spill: </p>
				</td>
				<td>
					<select id = \"spillSel\" onchange = \"updateTrainerSelect()\" onLoad = \"updateTrainerSelect()\">";

						$sql = "SELECT * from spill";
						$resultat = mysqli_query($dblink, $sql);
						while($rad = mysqli_fetch_assoc($resultat)){
							echo "<option value=\"{$rad['spillnavn']}\" >{$rad['spillnavn']}</option>";
						}

				echo "</select>
				</td>
			</tr>
			<br>
			<tr>
				<td>
					<p>Trener</p>
				</td>
				<td>
					<select id = \"trenerSel\" name = \"trener\">
						<script>updateTrainerSelect()</script>
					</select>
				</td>
			</tr>
		</table>
		<input type = \"submit\" value = \"Vis strategier\">
	</form>";
bunn($dblink);

?>