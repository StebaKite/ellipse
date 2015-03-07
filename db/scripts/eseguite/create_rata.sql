-- Table: paziente.rata

-- DROP TABLE paziente.rata;

CREATE TABLE paziente.rata
(
  idrata serial NOT NULL,
  idpreventivo integer NOT NULL,
  stato character(2) NOT NULL,
  datascadenza date NOT NULL,
  importo double precision NOT NULL,
  datainserimento date NOT NULL,
  datamodifica date,
  CONSTRAINT rata_pk PRIMARY KEY (idrata),
  CONSTRAINT preventivo_rata_fk FOREIGN KEY (idpreventivo)
      REFERENCES paziente.preventivo (idpreventivo) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE CASCADE
)
WITH (
  OIDS=FALSE
);
ALTER TABLE paziente.rata
  OWNER TO postgres;
