select 
	scontopercentuale,
	scontocontante,
	numerogiornirata,
	importorata,
	importodarateizzare,
	to_char(dataprimarata, 'DD/MM/YYYY') as dataprimarata

from paziente.preventivo 
where idpreventivo = %idpreventivo%
