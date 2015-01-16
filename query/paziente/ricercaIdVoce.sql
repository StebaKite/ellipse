SELECT 

	idvoce,
  	descrizione,
  	datainserimento,
  	datamodifica,
  	prezzo,
  	tipo,
  	idcategoria
  
FROM paziente.voce

WHERE codice = '%codice%'
