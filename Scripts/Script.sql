DROP TABLE paziente.notavocepreventivo;

CREATE TABLE paziente.notavocepreventivo (
	idnotavocepreventivo serial NOT NULL DEFAULT nextval('paziente.notavocepreventivo_idnotavocepreventivo_seq'::regclass),
	idvocepreventivo int4 NOT NULL,
	nota varchar NOT NULL,
	CONSTRAINT notavocepreventivo_pk PRIMARY KEY (idnotavocepreventivo),
	CONSTRAINT vocepreventivo_notavocepreventivo_fk FOREIGN KEY (idvocepreventivo) REFERENCES paziente.vocepreventivo(idvocepreventivo) ON DELETE CASCADE
);

CREATE INDEX notavocepreventivo_pk ON paziente.notavocepreventivo (idnotavocepreventivo);
