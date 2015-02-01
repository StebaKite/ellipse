select
	vocesottopreventivo.idvocesottopreventivo,
	vocesottopreventivo.codicevocelistino

from paziente.vocesottopreventivo as vocesottopreventivo
	
where vocesottopreventivo.idsottopreventivo = %idsottopreventivo%
  and vocesottopreventivo.nomeform = '%nomeform%'
  and vocesottopreventivo.nomecampoform = '%idnomecampo%'
