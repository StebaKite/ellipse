-- Mi sono accorto che la colonna è ridondante e inutile. 
-- C'è la data di nascita

ALTER TABLE paziente.paziente DROP COLUMN eta;

ALTER TABLE paziente.paziente ALTER COLUMN partitaiva TYPE character(11);

CREATE INDEX cognome
   ON paziente.paziente (cognome ASC NULLS LAST)
  TABLESPACE pg_default;