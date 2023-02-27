SELECT 
encomendas.data_hora, 
produtos.produto, produtos.preco_unidade,
encomendas_produtos.quantidade,
colaboradores.nome
CONCATusuario(ROUND(produtos.preco_unidade * encomendas_produtos.quantidade, 2),' R$') total
FROM encomendas_produtos LEFT JOIN encomendas 
ON encomendas.id = encomendas_produtos.id_encomenda
LEFT JOIN colaboradores.id  = encomendas.id_colaborador 
LEFT JOIN produtos
ON produtos.id = encomendas_produtos.id_produto

WHERE encomendas.id_colaborador = 5
