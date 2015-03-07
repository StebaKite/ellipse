-------------------------------------------------------------------------
-- Aggiunta la descrizione per permettere di modificare o aggiungere note
-------------------------------------------------------------------------

ALTER TABLE paziente.vocepreventivo
   ADD COLUMN descrizione character(200);