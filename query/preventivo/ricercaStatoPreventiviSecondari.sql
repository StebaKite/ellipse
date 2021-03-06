select count(*) totaleproposti
  from paziente.preventivo as preventivo
  
  		inner join paziente.sottopreventivo as sottopreventivo
  			on sottopreventivo.idpreventivo = preventivo.idpreventivo
  			
  where preventivo.idpreventivo = %idpreventivo%
    and preventivo.idpaziente = %idpaziente%
    and sottopreventivo.stato = '%stato%'
  group by sottopreventivo.stato