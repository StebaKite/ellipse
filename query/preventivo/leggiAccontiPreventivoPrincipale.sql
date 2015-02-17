select
	idacconto,
	datascadenza,
	descrizione,
	importo,
	stato
 from paziente.acconto
 where idpreventivo = %idpreventivo%
 order by datascadenza	