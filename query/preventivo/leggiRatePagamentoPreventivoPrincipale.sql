select
	datascadenza,
	stato,
	importo
 from paziente.rata
 where idpreventivo = %idpreventivo%
 order by datascadenza	