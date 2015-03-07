---------------------------------------------------------------------------------------
-- SB 9/2/2015 : aggiornamento fatto in occasione dell'accettazione del preventivo
---------------------------------------------------------------------------------------

-- Add Column: prezzo

ALTER TABLE paziente.vocecartellaclinica ADD COLUMN prezzo double precision;
ALTER TABLE paziente.vocecartellaclinica ALTER COLUMN prezzo SET NOT NULL;

-- Add Column: nomeform

ALTER TABLE paziente.vocecartellaclinica ADD COLUMN nomeform character(10);
ALTER TABLE paziente.vocecartellaclinica ALTER COLUMN nomeform SET NOT NULL;
ALTER TABLE paziente.vocecartellaclinica ALTER COLUMN nomeform SET DEFAULT ' '::bpchar;

---------------------------------------------------------------------------------------
-- SB 10/2/2015 : aggiornamento fatto in occasione dell'accettazione del preventivo
---------------------------------------------------------------------------------------

-- Drop delle FK verso il preventivo / sottopreventivo
--
-- Questo per poter creare una cartella clinica anche senza preventivo

ALTER TABLE paziente.cartellaclinica
  DROP CONSTRAINT preventivo_cartellaclinica_fk;

ALTER TABLE paziente.cartellaclinica
  DROP CONSTRAINT sottopreventivo_cartellaclinica_fk;

-- L'idpreventivo deve essere nullabile
  
ALTER TABLE paziente.cartellaclinica DROP COLUMN idpreventivo;
ALTER TABLE paziente.cartellaclinica ADD COLUMN idpreventivo integer;
