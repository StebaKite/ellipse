select
	vocepreventivo.idvocepreventivo,
	vocepreventivo.codicevocelistino

from paziente.vocepreventivo as vocepreventivo
	
where vocepreventivo.idpreventivo = %idpreventivo%
  and vocepreventivo.nomeform = '%nomeform%'
  and vocepreventivo.nomecampoform = '%idnomecampo%'
