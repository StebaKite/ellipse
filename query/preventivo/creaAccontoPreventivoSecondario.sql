INSERT INTO paziente.accontosottopreventivo
VALUES (nextval('paziente.accontosottopreventivo_idaccontosottopreventivo_seq'), %idsottopreventivo%, '00', '%descrizione%', '%datascadenza%', %importo%, current_date, null) RETURNING idaccontosottopreventivo
