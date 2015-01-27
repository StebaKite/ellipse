--
-- SB 27/01/2015 : Tolto il NOT NULL sulla datamodifica 
--

ALTER TABLE paziente.vocepreventivo
   ALTER COLUMN datamodifica DROP NOT NULL;
