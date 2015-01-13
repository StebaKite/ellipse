INSERT INTO strumenti.guida 
VALUES (nextval('strumenti.guida_idguida_seq'), '%progressivo%', '%classe%', '%filepath%', '%stato%') RETURNING idguida