SELECT 

	idlistino,
  	descrizionelistino,
  	datainserimento,
  	datamodifica
  
FROM paziente.listino

WHERE codice = '%codice%'
