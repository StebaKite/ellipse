INSERT INTO paziente.notapreventivo
VALUES (nextval('paziente.notapreventivo_idnotapreventivo_seq'), %idpreventivo%, '%nota%', current_date, null) RETURNING idnotapreventivo
