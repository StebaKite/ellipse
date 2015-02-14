--
-- SB 27/01/2015 : 
--
-- 1. Tolto il NOT NULL sulla datamodifica
-- 2. Inserita la colonna nomeform
--

ALTER TABLE paziente.vocepreventivo
   ALTER COLUMN datamodifica DROP NOT NULL;
   
ALTER TABLE paziente.vocepreventivo
   ADD COLUMN nomeform character(10) NOT NULL DEFAULT 'singoli';   

ALTER TABLE paziente.vocesottopreventivo
   ADD COLUMN nomeform character(10) NOT NULL DEFAULT 'singoli';   