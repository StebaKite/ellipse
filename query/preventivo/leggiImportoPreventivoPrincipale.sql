select sum(vocepreventivo.prezzo) as totaleimportoprincipale
  from paziente.preventivo as preventivo
  
  		inner join paziente.vocepreventivo as vocepreventivo
  			on vocepreventivo.idpreventivo = preventivo.idpreventivo

  where preventivo.idpaziente = %idpaziente%
    and preventivo.idpreventivo = %idpreventivo%  		