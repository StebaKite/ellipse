---------------------------------------------------------------------------------------
-- SB 10/2/2015 : aggiunte le colonne per le condizioni di pagamento
---------------------------------------------------------------------------------------

ALTER TABLE paziente.sottopreventivo
   ADD COLUMN scontopercentuale smallint;

ALTER TABLE paziente.sottopreventivo
   ADD COLUMN scontocontante double precision;

ALTER TABLE paziente.sottopreventivo
   ADD COLUMN accontoiniziocura double precision;

ALTER TABLE paziente.sottopreventivo
   ADD COLUMN accontometacura double precision;

ALTER TABLE paziente.sottopreventivo
   ADD COLUMN saldofinecura double precision;

ALTER TABLE paziente.sottopreventivo
   ADD COLUMN numerogiornirata smallint;

ALTER TABLE paziente.sottopreventivo
   ADD COLUMN importorata double precision;

ALTER TABLE paziente.sottopreventivo
   ADD COLUMN importodarateizzare double precision;

ALTER TABLE paziente.sottopreventivo
   ADD COLUMN dataprimarata date;
