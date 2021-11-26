SET search_path TO lbaw2191;

DROP VIEW IF EXISTS texto_questao;

CREATE VIEW questao_completa AS
    SELECT 
        questao.id AS id,
        interacao_utilizador.id AS id_interacao,
        questao.titulo AS titulo,
        interacao_utilizador.texto AS texto,
    FROM 
        questao 
    INNER JOIN 
        interacao_utilizador 
        ON questao.id_interacao = interacao_utilizador.id;
