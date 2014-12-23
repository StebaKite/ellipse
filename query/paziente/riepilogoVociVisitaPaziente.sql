select
	voce.codicevocelistino,
	voce.nomecampoform,
	vocelistino.descrizionevoce

from paziente.visita as visita

	inner join paziente.paziente as paziente
		on paziente.idpaziente = visita.idpaziente
	
	left outer join paziente.vocevisita as voce
		on voce.idvisita = visita.idvisita
	
	inner join paziente.vocelistino as vocelistino
		on  vocelistino.idlistino = paziente.idlistino
		and vocelistino.codicevocelistino = voce.codicevocelistino
	
where paziente.idpaziente = %idpaziente%
  and visita.idvisita = %idvisita%
