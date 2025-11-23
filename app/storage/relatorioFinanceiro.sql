select distinct 
    p.nome, 
    p.telefone, 
    sum(pa.valor) as valor_pendente    
from pessoas p 
inner join debitos d on p.id = d.pessoa_id
inner join parcelas pa on pa.debito_id = d.id 
where pa.pago = false 
group by p.nome, p.telefone;
