select
	codicevocelistino,
	descrizionevoce
	
from paziente.vocelistino
where idlistino = %idlistino%
