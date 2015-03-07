INSERT INTO paziente.notasottopreventivo
VALUES (nextval('paziente.notasottopreventivo_idnotasottopreventivo_seq'), %idpreventivo%, '%nota%', current_date, null) RETURNING idnotasottopreventivo
