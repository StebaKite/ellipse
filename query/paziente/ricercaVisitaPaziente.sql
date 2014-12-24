SELECT 
  paziente.idpaziente,
  paziente.idlistino,
  paziente.cognome, 
  paziente.nome, 
  to_char(paziente.datanascita, 'DD/MM/YYYY') as datanascita,
  visita.idpaziente, 
  to_char(visita.datainserimento, 'DD/MM/YYYY') as datainserimento,
  to_char(visita.datamodifica, 'DD/MM/YYYY') as datamodifica,
  case visita.stato
	when '00' then 'In corso'
	when '01' then 'Preventivata'
  end as stato,
  visita.idvisita
  
FROM paziente.paziente

	inner join paziente.visita as visita
	on visita.idpaziente = paziente.idpaziente

WHERE paziente.idpaziente = %idpaziente%
order by visita.idvisita desc
