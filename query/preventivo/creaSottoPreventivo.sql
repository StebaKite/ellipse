INSERT INTO paziente.sottopreventivo
VALUES (nextval('paziente.sottopreventivo_idsottopreventivo_seq'), '%idpreventivo%', '00', current_date, null) RETURNING idsottopreventivo
