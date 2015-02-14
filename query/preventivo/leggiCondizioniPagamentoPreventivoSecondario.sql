select 
	scontopercentuale,
	scontocontante,
	accontoiniziocura,
	accontometacura,
	saldofinecura,
	numerogiornirata,
	importorata,
	importodarateizzare,
	dataprimarata

from paziente.sottopreventivo 
where idsottopreventivo = %idsottopreventivo%
