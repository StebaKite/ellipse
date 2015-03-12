select
	notavocesottopreventivo.idnotavocesottopreventivo as idnotavocepreventivo,
	notavocesottopreventivo.nota,
	notavocesottopreventivo.datainserimento,
	notavocesottopreventivo.datamodifica
  from paziente.notavocesottopreventivo as notavocesottopreventivo
  where idvocesottopreventivo = %idvocepreventivo%
  order by notavocesottopreventivo.datainserimento, notavocesottopreventivo.idnotavocesottopreventivo
  
	