INSERT INTO paziente.acconto
VALUES (nextval('paziente.acconto_idacconto_seq'), %idpreventivo%, '00', '%descrizione%', '%datascadenza%', %importo%, current_date, null) RETURNING idacconto
