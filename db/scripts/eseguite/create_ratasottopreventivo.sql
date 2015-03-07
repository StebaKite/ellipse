-- Table: paziente.ratasottopreventivo

-- DROP TABLE paziente.ratasottopreventivo;

CREATE TABLE paziente.ratasottopreventivo
(
  idrata serial NOT NULL,
  idsottopreventivo integer NOT NULL,
  stato character(2) NOT NULL,
  datascadenza date NOT NULL,
  importo double precision NOT NULL,
  datainserimento date NOT NULL,
  datamodifica date,
  CONSTRAINT ratasottopreventivo_pk PRIMARY KEY (idrata),
  CONSTRAINT sottopreventivo_ratasottopreventivo_fk FOREIGN KEY (idsottopreventivo)
      REFERENCES paziente.sottopreventivo (idsottopreventivo) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE paziente.ratasottopreventivo
  OWNER TO postgres;
