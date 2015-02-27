---------------------------------------------------------------------
-- SB 26/2/2015:  Aggiunte le colonne di audit per la gestione e ordinamento delle note
---------------------------------------------------------------------

ALTER TABLE paziente.notasottopreventivo
   ADD COLUMN datainserimento date NOT NULL;

ALTER TABLE paziente.notasottopreventivo
   ADD COLUMN datamodifica date;
