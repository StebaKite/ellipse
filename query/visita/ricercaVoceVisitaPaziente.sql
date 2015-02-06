select
	vocevisita.idvocevisita,
	vocevisita.codicevocelistino

from paziente.vocevisita as vocevisita
	
where vocevisita.idvisita = %idvisita%
  and vocevisita.nomeform = '%nomeform%'
  and vocevisita.nomecampoform = '%idnomecampo%'
