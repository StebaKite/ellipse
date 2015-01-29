SELECT
	vocesottopreventivo.idvocesottopreventivo,
	vocesottopreventivo.codicevocelistino
FROM paziente.vocesottopreventivo as vocesottopreventivo
WHERE vocesottopreventivo.idsottopreventivo = %idsottopreventivo%
  AND vocesottopreventivo.nomeform = '%nomeform%'
  AND vocesottopreventivo.nomecampoform = '%idnomecampo%'
