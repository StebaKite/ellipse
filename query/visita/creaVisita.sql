INSERT INTO paziente.visita 
VALUES (nextval('paziente.visita_idvisita_seq'), '%idpaziente%', current_date, null, '00' ) RETURNING idvisita
