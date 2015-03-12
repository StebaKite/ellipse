INSERT INTO paziente.notavocepreventivo
VALUES (nextval('paziente.notavocepreventivo_idnotavocepreventivo_seq'), %idvocepreventivo%, '%nota%', current_date, null) RETURNING idnotavocepreventivo
