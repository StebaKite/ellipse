select cartellaclinica.stato
  from paziente.cartellaclinica as cartellaclinica  			
  where cartellaclinica.idpreventivo = %idpreventivo%
    and cartellaclinica.idpaziente = %idpaziente%
