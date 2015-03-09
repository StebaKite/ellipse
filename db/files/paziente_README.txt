

PROBLEMI TROVATI
--------------------
1. Il codice della provincia non c'è sempre, la sua posizione è fra il CAP e la data di nascita: Se manca inserisco XX
2. Manca il sesso: inserisco M a tutti
3. Manca il luogo di nascita: assumo come luogo di nascita la provincia di residenza
4. Il CAP non c'è sempre: se manca inserisco 99999
5. La data di nascita è in un formato errato (con l'ora a zero..): ignoro la seconda parte e prendo solo la data
6. Manca un riferimento al medico: metto a tutti il numero 1 (uso il campo finale a destra, che è sempre un 1 alcune volte 3...può andare...)
7. Manca un riferimento al laboratorio: metto a tutti il numero 1 (uso il campo finale...)
8. Manca un riferimento al listino: metto a tutti il numero 1 (uso il campo finale...)
9. Per alcuni manca la data di nascita: metto 01/01/0001  poi va sistemata


MODIFICHE DA FARE SUL FILE
---------------------------
1. va inserito il doppio apice davanti alla data di nascita -> replace di  ;1/  in  ;"1/   per ciascun giorno del mese
2. va tolta l'ora a zero e inserito l'apice doppio che chiude la data di nascita -> replace di 0.00.00;  in  "; 
3. va sostituito  MARIA HOE'  in   Maria Hoè
4. va sostituito  S";1   in  S";1;    chiusura finale
5. vanno sostituiti gli '  in  ''
6. vanno sostituiti i n°  in  ,
7. tutte le lettere accentate fatte con '  vanno sostituite


  COLONNE TABELLA	
--------------------
  idpaziente serial NOT NULL					
  cognome character varying(50) NOT NULL		pos.0
  nome character varying(50) NOT NULL			pos.1
  tipo character(1) NOT NULL					STD
  indirizzo character varying(100) NOT NULL		pos.2
  citta character varying(50) NOT NULL			pos.3
  cap character(10) NOT NULL					pos.5
  provincia character(10) NOT NULL				pos.6
  sesso character(1) NOT NULL,					M
  luogonascita character varying(50) NOT NULL	pos.6
  datanascita date NOT NULL						pos.7
  codicefiscale character(16)					pos.8
  partitaiva character(10)						pos.9
  telefonofisso character(20) NOT NULL			pos.10
  telefonoportatile character(20)				pos.11
  email character varying(100)					pos.12
  datainserimento date NOT NULL
  datamodifica date,
  fotopaziente bytea,
  idmedico integer NOT NULL						pos.15
  idlaboratorio integer NOT NULL				pos.15
  idlistino integer NOT NULL					pos.15
