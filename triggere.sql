DELIMITER $$
 
DROP TRIGGER IF EXISTS bruker_b_ins_trg $$
 
CREATE TRIGGER bruker_b_ins_trg
BEFORE INSERT ON bruker
FOR EACH ROW
BEGIN
  SET NEW.brukernavn = CONCAT(SUBSTRING(UPPER(TRIM(NEW.brukernavn)), 1, 1), SUBSTRING(LOWER(TRIM(NEW.brukernavn)), 2));
END $$

DROP TRIGGER IF EXISTS trenerspokemon_b_ins_trg $$
 
CREATE TRIGGER trenerspokemon_b_ins_trg
BEFORE INSERT ON trenerspokemon
FOR EACH ROW
BEGIN
	DECLARE antall INT;
	DECLARE trenerGen INT;
	DECLARE pokemonGen INT;
	SET antall = (SELECT COUNT(*) FROM trenerspokemon WHERE NEW.Trener_idTrener = trenerspokemon.Trener_idTrener);
    IF antall >= 6 
      THEN SIGNAL SQLSTATE '80000'
      SET MESSAGE_TEXT = 'Trener kan ikke ha flere enn 6 Pokémon';
    END IF;

    SET pokemonGen = (SELECT generasjon FROM pokemon
    	WHERE pokemon.idPokemon = NEW.Pokemon_idPokemon);

    SET trenerGen = (SELECT generasjon FROM trener
    	JOIN spill ON trener.Spill_idSpill = spill.idSpill
    	WHERE NEW.Trener_idTrener = trener.idTrener
    	);
    IF trenerGen < pokemonGen 
      THEN SIGNAL SQLSTATE '80000'
      SET MESSAGE_TEXT = "Pokémon fra en nyere generasjon enn treneren.";
    END IF;

END 