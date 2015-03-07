-- Table: paziente.accontosottopreventivo

-- DROP TABLE paziente.accontosottopreventivo;

CREATE TABLE paziente.accontosottopreventivo
(
  idaccontosottopreventivo serial NOT NULL,
  idsottopreventivo integer NOT NULL,
  stato character(2) NOT NULL,
  descrizione character(50) NOT NULL,
  datascadenza date NOT NULL,
  importo double precision NOT NULL,
  datainserimento date NOT NULL,
  datamodifica date,
  CONSTRAINT accontosottopreventivo_pk PRIMARY KEY (idaccontosottopreventivo),
  CONSTRAINT sottopreventivo_accontosottopreventivo_fk FOREIGN KEY (idsottopreventivo)
      REFERENCES paziente.sottopreventivo (idsottopreventivo) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE paziente.accontosottopreventivo
  OWNER TO postgres;
