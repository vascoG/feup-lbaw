/*
    Full text search on question title and question title prioritizing title
*/

SET search_path TO lbaw2191;

DROP TRIGGER IF EXISTS atualiza_tsvector_titulo_questao ON questao CASCADE;
DROP TRIGGER IF EXISTS atualiza_tsvector_texto_questao ON interacao_utilizador CASCADE;
DROP INDEX IF EXISTS pesquisa_questao;

ALTER TABLE questao
ADD COLUMN IF NOT EXISTS tsvectors TSVECTOR;

CREATE OR REPLACE FUNCTION atualiza_tsvector_titulo_questao() RETURNS TRIGGER AS $$
DECLARE
    texto_questao VARCHAR;
BEGIN
    SELECT interacao_utilizador.texto INTO texto_questao 
    FROM interacao_utilizador 
    WHERE NEW.id_interacao = interacao_utilizador.id; 
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
            setweight(to_tsvector('portuguese', NEW.titulo), 'A'),
            setweight(to_tsvector('portuguese', texto_questao), 'B')
        );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW.titulo <> OLD.titulo) THEN
            NEW.tsvectors = (
                setweight(to_tsvector('portuguese', NEW.titulo), 'A'),
                setweight(to_tsvector('portuguese', texto_questao), 'B')
            );
        END IF;
    END IF;
    RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE OR REPLACE FUNCTION atualiza_tsvector_texto_questao() RETURNS TRIGGER AS $$
DECLARE
    titulo_questao VARCHAR;
BEGIN
    SELECT questao.texto INTO titulo_questao 
    FROM questao 
    WHERE NEW.id = questao.id_interacao; 
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
            setweight(to_tsvector('portuguese', titulo_questao), 'A'),
            setweight(to_tsvector('portuguese', NEW.texto), 'B')
        );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW.texto <> OLD.texto) THEN
            NEW.tsvectors = (
                setweight(to_tsvector('portuguese', titulo_questao), 'A'),
                setweight(to_tsvector('portuguese', NEW.texto), 'B')
            );
        END IF;
    END IF;
    RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER atualiza_tsvector_titulo_questao
    BEFORE INSERT OR UPDATE ON questao
    FOR EACH ROW
    EXECUTE PROCEDURE atualiza_tsvector_titulo_questao();

CREATE TRIGGER atualiza_tsvector_texto_questao
    BEFORE INSERT OR UPDATE ON interacao_utilizador
    FOR EACH ROW
    EXECUTE PROCEDURE atualiza_tsvector_texto_questao();

CREATE INDEX pesquisa_questao ON questao USING GIN (tsvectors);