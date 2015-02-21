select
	to_char(datascadenza, 'DD/MM/YYYY') as datascadenza,
	datascadenza as data,
	stato,
	importo
 from paziente.ratasottopreventivo
 where idsottopreventivo = %idsottopreventivo%
 order by data	