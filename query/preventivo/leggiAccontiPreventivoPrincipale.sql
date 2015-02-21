select
	idacconto,
	to_char(datascadenza, 'DD/MM/YYYY') as datascadenza,
	datascadenza as data,
	descrizione,
	importo,
	stato
 from paziente.acconto
 where idpreventivo = %idpreventivo%
 order by data