
CREATE SEQUENCE paziente.sottopreventivo_idsottopreventivo_seq;
CREATE TABLE paziente.sottopreventivo (
                idsottopreventivo INTEGER NOT NULL DEFAULT nextval('paziente.sottopreventivo_idsottopreventivo_seq'),
                idpreventivo INTEGER NOT NULL,
                stato CHAR(2) NOT NULL,
                datainserimento DATE NOT NULL,
                datamodifica DATE,
                CONSTRAINT sottopreventivo_pk PRIMARY KEY (idsottopreventivo)
);
ALTER SEQUENCE paziente.sottopreventivo_idsottopreventivo_seq OWNED BY paziente.sottopreventivo.idsottopreventivo;

-----------------------------------------------------

CREATE SEQUENCE paziente.notasottopreventivo_idnotasottopreventivo_seq;
CREATE TABLE paziente.notasottopreventivo (
                idnotasottopreventivo INTEGER NOT NULL DEFAULT nextval('paziente.notasottopreventivo_idnotasottopreventivo_seq'),
                idsottopreventivo INTEGER NOT NULL,
                nota VARCHAR(1000) NOT NULL,
                CONSTRAINT notasottopreventivo_pk PRIMARY KEY (idnotasottopreventivo)
);
ALTER SEQUENCE paziente.notasottopreventivo_idnotasottopreventivo_seq OWNED BY paziente.notasottopreventivo.idnotasottopreventivo;

-----------------------------------------------------

CREATE SEQUENCE paziente.vocesottopreventivo_idvocesottopreventivo_seq;
CREATE TABLE paziente.vocesottopreventivo (
                idvocesottopreventivo INTEGER NOT NULL DEFAULT nextval('paziente.vocesottopreventivo_idvocesottopreventivo_seq'),
                idsottopreventivo INTEGER NOT NULL,
                nomeCampoForm CHAR(50) NOT NULL,
                codicevocelistino CHAR(10) NOT NULL,
                stato CHAR(2) NOT NULL,
                datainserimento DATE NOT NULL,
                datamodifica DATE,
                prezzo DOUBLE PRECISION NOT NULL,
                CONSTRAINT vocesottopreventivo_pk PRIMARY KEY (idvocesottopreventivo)
);
ALTER SEQUENCE paziente.vocesottopreventivo_idvocesottopreventivo_seq OWNED BY paziente.vocesottopreventivo.idvocesottopreventivo;

-----------------------------------------------------

CREATE SEQUENCE paziente.notavocesottopreventivo_idnotavocesottopreventivo_seq;
CREATE TABLE paziente.notavocesottopreventivo (
                idnotavocesottopreventivo INTEGER NOT NULL DEFAULT nextval('paziente.notavocesottopreventivo_idnotavocesottopreventivo_seq'),
                idvocesottopreventivo INTEGER NOT NULL,
                nota VARCHAR(1000) NOT NULL,
                CONSTRAINT notavocesottopreventivo_pk PRIMARY KEY (idnotavocesottopreventivo)
);
ALTER SEQUENCE paziente.notavocesottopreventivo_idnotavocesottopreventivo_seq OWNED BY paziente.notavocesottopreventivo.idnotavocesottopreventivo;

-----------------------------------------------------

ALTER TABLE paziente.sottopreventivo ADD CONSTRAINT preventivo_sottopreventivo_fk
FOREIGN KEY (idpreventivo)
REFERENCES paziente.preventivo (idpreventivo)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE paziente.vocesottopreventivo ADD CONSTRAINT sottopreventivo_vocesottopreventivo_fk
FOREIGN KEY (idsottopreventivo)
REFERENCES paziente.sottopreventivo (idsottopreventivo)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE paziente.notasottopreventivo ADD CONSTRAINT sottopreventivo_notasottopreventivo_fk
FOREIGN KEY (idsottopreventivo)
REFERENCES paziente.sottopreventivo (idsottopreventivo)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE paziente.cartellaclinica ADD CONSTRAINT sottopreventivo_cartellaclinica_fk
FOREIGN KEY (idpreventivo)
REFERENCES paziente.sottopreventivo (idsottopreventivo)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;

ALTER TABLE paziente.notavocesottopreventivo ADD CONSTRAINT vocesottopreventivo_notavocesottopreventivo_fk
FOREIGN KEY (idvocesottopreventivo)
REFERENCES paziente.vocesottopreventivo (idvocesottopreventivo)
ON DELETE CASCADE
ON UPDATE NO ACTION
NOT DEFERRABLE;
