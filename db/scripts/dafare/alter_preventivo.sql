---------------------------------------------------------------------------------------
-- SB 10/2/2015 : aggiunte le colonne per le condizioni di pagamento
---------------------------------------------------------------------------------------

ALTER TABLE paziente.preventivo
   ADD COLUMN scontopercentuale smallint;

ALTER TABLE paziente.preventivo
   ADD COLUMN scontocontante double precision;

ALTER TABLE paziente.preventivo
   ADD COLUMN accontoiniziocura double precision;

ALTER TABLE paziente.preventivo
   ADD COLUMN accontometacura double precision;

ALTER TABLE paziente.preventivo
   ADD COLUMN saldofinecura double precision;

ALTER TABLE paziente.preventivo
   ADD COLUMN numerogiornirata smallint;

ALTER TABLE paziente.preventivo
   ADD COLUMN importorata double precision;

ALTER TABLE paziente.preventivo
   ADD COLUMN importodarateizzare double precision;

ALTER TABLE paziente.preventivo
   ADD COLUMN dataprimarata date;
