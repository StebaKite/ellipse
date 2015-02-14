select 
	scontopercentuale,
	scontocontante,
	accontoiniziocura,
	accontometacura,
	saldofinecura,
	numerogiornirata,
	importorata,
	importodarateizzare,
	to_char(dataprimarata, 'DD/MM/YYYY') as dataprimarata	
from paziente.preventivo 
where idpreventivo = %idpreventivo%
