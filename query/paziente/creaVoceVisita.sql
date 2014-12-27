INSERT INTO paziente.vocevisita 
VALUES (nextval('paziente.vocevisita_idvocevisita_seq'), %idvisita%, '%nomeForm%', '%nomecampoform%', '%codicevocelistino%', current_date, null )
