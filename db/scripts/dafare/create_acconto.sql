-- Table: paziente.acconto

-- DROP TABLE paziente.acconto;

CREATE TABLE paziente.acconto
(
  idacconto serial NOT NULL,
  idpreventivo integer NOT NULL,
  stato character(2) NOT NULL,
  descrizione character(50) NOT NULL,
  datascadenza date NOT NULL,
  importo double precision NOT NULL,
  datainserimento date NOT NULL,
  datamodifica date,
  CONSTRAINT acconto_pk PRIMARY KEY (idacconto),
  CONSTRAINT preventivo_acconto_fk FOREIGN KEY (idpreventivo)
      REFERENCES paziente.preventivo (idpreventivo) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE paziente.acconto
  OWNER TO postgres;
