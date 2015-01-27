INSERT INTO paziente.preventivo
VALUES (nextval('paziente.preventivo_idpreventivo_seq'), '%idpaziente%', '00', current_date, null) RETURNING idpreventivo
