INSERT INTO paziente.ratasottopreventivo
VALUES (nextval('paziente.ratasottopreventivo_idrata_seq'), %idsottopreventivo%, '00', '%datascadenza%', %importo%, current_date, null) RETURNING idrata
