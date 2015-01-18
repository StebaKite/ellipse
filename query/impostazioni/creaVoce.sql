INSERT INTO paziente.voce 
VALUES (nextval('paziente.voce_idvoce_seq'), '%descrizione%', current_date, null, '%prezzo%', '%codice%', '%tipo%', '%idcategoria%') RETURNING idvoce