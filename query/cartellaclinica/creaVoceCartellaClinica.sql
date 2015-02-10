INSERT INTO paziente.vocecartellaclinica
VALUES (nextval('paziente.vocecartellaclinica_idvocecartellaclinica_seq'), %idcartellaclinica%, 
'%nomecampoform%', '%codicevocelistino%', '00', current_date, null, %prezzo%, '%nomeform%') RETURNING idvocecartellaclinica
