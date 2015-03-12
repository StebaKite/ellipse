INSERT INTO paziente.notavocesottopreventivo
VALUES (nextval('paziente.notavocesottopreventivo_idnotavocesottopreventivo_seq'), %idvocepreventivo%, '%nota%', current_date, null) RETURNING idnotavocesottopreventivo
