INSERT INTO paziente.cartellaclinica
VALUES (nextval('paziente.cartellaclinica_idcartellaclinica_seq'), %idpaziente%, '00', current_date, null, %idpreventivo%) RETURNING idcartellaclinica
