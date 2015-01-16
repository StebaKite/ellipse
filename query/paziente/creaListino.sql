INSERT INTO paziente.listino 
VALUES (nextval('paziente.listino_idlistino_seq'), '%descrizione%', current_date, null, '%codice%' ) RETURNING idlistino