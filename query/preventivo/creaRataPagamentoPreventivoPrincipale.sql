INSERT INTO paziente.rata
VALUES (nextval('paziente.rata_idrata_seq'), %idpreventivo%, '00', '%datascadenza%', %importo%, current_date, null) RETURNING idrata
