INSERT INTO paziente.categoria 
VALUES (nextval('paziente.categoria_idcategoria_seq'), '%codicecategoria%', '%descrizionecategoria%', current_date, null) RETURNING idcategoria