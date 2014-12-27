select
	vocevisita.idvocevisita,
	vocevisita.codicevocelistino

from paziente.vocevisita as vocevisita
	
where vocevisita.idvisita = %idvisita%
  and vocevisita.nomeform = 'singoli'
  and vocevisita.nomecampoform = '%idnomecampo%'
