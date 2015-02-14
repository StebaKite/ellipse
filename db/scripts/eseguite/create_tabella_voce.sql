-------------------------------------------------------------------------------
-- Table: paziente.voce

-- DROP TABLE paziente.voce;

CREATE TABLE paziente.voce
(
  idvoce integer NOT NULL DEFAULT nextval('paziente.voce_idvoce_seq'::regclass),
  descrizione character(100),
  datainserimento date NOT NULL,
  datamodifica date,
  prezzo double precision NOT NULL,
  codice character(3) NOT NULL,
  tipo character(3) NOT NULL,
  CONSTRAINT voce_pk PRIMARY KEY (idvoce)
)
WITH (
  OIDS=TRUE
);
ALTER TABLE paziente.voce
  OWNER TO postgres;
