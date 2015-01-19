INSERT INTO paziente.listino
VALUES (nextval('paziente.listino_idlistino_seq'), '%descrizionelistino%', current_date, null, '%codicelistino%') RETURNING idlistino