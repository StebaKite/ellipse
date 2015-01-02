----------------------------------------------------------------------------------
-- Table: paziente.vocelistino

DROP TABLE paziente.vocelistino;

CREATE TABLE paziente.vocelistino
(
  idvocelistino integer NOT NULL,
  idlistino integer NOT NULL,
  prezzo double precision NOT NULL,
  datainserimento date NOT NULL,
  datamodifica date,
  CONSTRAINT vocelistino_pk PRIMARY KEY (idvocelistino),
  CONSTRAINT listino_vocelistino_fk FOREIGN KEY (idlistino)
      REFERENCES paziente.listino (idlistino) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION,
  CONSTRAINT voce_vocelistino_fk FOREIGN KEY (idvocelistino)
      REFERENCES paziente.voce (idvoce) MATCH SIMPLE
      ON UPDATE NO ACTION ON DELETE NO ACTION
)
WITH (
  OIDS=FALSE
);
ALTER TABLE paziente.vocelistino
  OWNER TO postgres;
