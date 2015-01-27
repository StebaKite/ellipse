SELECT vocelistino.prezzo
  FROM paziente.vocelistino as vocelistino
 WHERE vocelistino.idvocelistino = %idvocelistino%
   AND vocelistino.idlistino = %idlistino%
