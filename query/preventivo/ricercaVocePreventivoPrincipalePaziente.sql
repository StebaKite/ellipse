SELECT
	vocepreventivo.idvocepreventivo,
	vocepreventivo.codicevocelistino,
	vocepreventivo.prezzo

FROM paziente.vocepreventivo as vocepreventivo
	
WHERE vocepreventivo.idpreventivo = %idpreventivo%
  AND vocepreventivo.nomeform = '%nomeform%'
  AND vocepreventivo.nomecampoform = '%idnomecampo%'
  AND vocepreventivo.stato = '00'
