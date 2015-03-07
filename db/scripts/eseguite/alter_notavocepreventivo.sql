-----------------------------------------------------------------------------------------------------------
-- SB 26/2/2015:  Aggiunte le colonne di audit per la gestione e ordinamento delle note sulla singola voce
-----------------------------------------------------------------------------------------------------------

ALTER TABLE paziente.notavocepreventivo
   ADD COLUMN datainserimento date NOT NULL;

ALTER TABLE paziente.notavocepreventivo
   ADD COLUMN datamodifica date;
