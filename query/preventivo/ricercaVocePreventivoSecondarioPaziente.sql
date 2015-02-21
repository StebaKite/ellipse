SELECT
	vocesottopreventivo.idvocesottopreventivo,
	vocesottopreventivo.codicevocelistino,
	vocesottopreventivo.prezzo

FROM paziente.vocesottopreventivo as vocesottopreventivo
	
WHERE vocesottopreventivo.idsottopreventivo = %idsottopreventivo%
  AND vocesottopreventivo.nomeform = '%nomeform%'
  AND vocesottopreventivo.nomecampoform = '%idnomecampo%'
  AND vocesottopreventivo.stato = '00'
  
