select
	to_char(datascadenza, 'DD/MM/YYYY') as datascadenza,
	datascadenza as data,
	stato,
	importo
 from paziente.rata
 where idpreventivo = %idpreventivo%
 order by data	