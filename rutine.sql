DELIMITER $$
 
DROP PROCEDURE IF EXISTS sisteStrategier $$
 
CREATE PROCEDURE sisteStrategier
(
	OUT tekstVar VARCHAR(500),
	OUT brukernavnVar VARCHAR(20),
	OUT stratidVar INT(11)
)
BEGIN
	SELECT  strategiTekst,
			brukernavn,
			idStrategi
	FROM strategi
	JOIN bruker 
	ON strategi.Bruker_idBruker = bruker.idBruker 
	ORDER BY strategi.dato DESC;
END