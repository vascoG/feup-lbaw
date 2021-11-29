SET search_path TO lbaw2191;

/*
  TABLE CREATION START HERE
*/

DROP TABLE IF EXISTS utilizador CASCADE;
DROP TABLE IF EXISTS utilizador_ativo CASCADE;
DROP TABLE IF EXISTS utilizador_banido CASCADE;
DROP TABLE IF EXISTS apelo_desbloqueio CASCADE;
DROP TABLE IF EXISTS medalha CASCADE;
DROP TABLE IF EXISTS notificacao CASCADE;
DROP TABLE IF EXISTS historico_interacao CASCADE;
DROP TABLE IF EXISTS resposta CASCADE;
DROP TABLE IF EXISTS comentario CASCADE;
DROP TABLE IF EXISTS questao CASCADE;
DROP TABLE IF EXISTS utilizador_ativo_notificacao CASCADE;
DROP TABLE IF EXISTS utilizador_ativo_medalha CASCADE;
DROP TABLE IF EXISTS questao_seguida CASCADE;
DROP TABLE IF EXISTS questao_avaliada CASCADE;
DROP TABLE IF EXISTS resposta_avaliada CASCADE;
DROP TABLE IF EXISTS etiqueta CASCADE;
DROP TABLE IF EXISTS questao_etiqueta CASCADE;
DROP TABLE IF EXISTS palavra_passe CASCADE;


CREATE TABLE palavra_passe(
  id SERIAL PRIMARY KEY,
  palavra_passe TEXT NOT NULL,
  palavra_passe_salt TEXT UNIQUE NOT NULL
);

CREATE TABLE utilizador(
  id SERIAL PRIMARY KEY,
  imagem_perfil TEXT,
  nome_utilizador TEXT UNIQUE NOT NULL,
  nome TEXT NOT NULL,
  id_palavra_passe INTEGER UNIQUE NOT NULL REFERENCES palavra_passe(id) ON UPDATE CASCADE,
  moderador BOOLEAN NOT NULL,
  administrador BOOLEAN NOT NULL
);

CREATE TABLE utilizador_ativo(
  id SERIAL PRIMARY KEY,
  id_utilizador INTEGER UNIQUE NOT NULL REFERENCES utilizador(id) ON UPDATE CASCADE
);

CREATE TABLE utilizador_banido(
  id SERIAL PRIMARY KEY,
  id_utilizador INTEGER UNIQUE NOT NULL REFERENCES utilizador(id) ON UPDATE CASCADE
);

CREATE TABLE apelo_desbloqueio(
  id SERIAL PRIMARY KEY,
  motivo TEXT NOT NULL
);

CREATE TABLE medalha(
  id SERIAL PRIMARY KEY,
  nome TEXT UNIQUE NOT NULL,
  imagem TEXT UNIQUE NOT NULL
);

CREATE TABLE questao(
  id SERIAL PRIMARY KEY,
  texto TEXT NOT NULL,
  data_publicacao TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  autor INTEGER REFERENCES utilizador_ativo(id),
  titulo TEXT NOT NULL
);

CREATE TABLE resposta(
  id SERIAL PRIMARY KEY,
  texto TEXT NOT NULL,
  data_publicacao TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  autor INTEGER REFERENCES utilizador_ativo(id),
  id_questao INTEGER NOT NULL REFERENCES questao(id),
  resposta_aceite BOOLEAN NOT NULL
);

CREATE TABLE comentario(
  id SERIAL PRIMARY KEY,
  texto TEXT NOT NULL,
  data_publicacao TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  autor INTEGER REFERENCES utilizador_ativo(id),
  id_questao INTEGER REFERENCES questao(id),
  id_resposta INTEGER REFERENCES resposta(id)
);

CREATE TABLE notificacao(
  id SERIAL PRIMARY KEY,
  texto TEXT NOT NULL,
  data TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  id_questao INTEGER REFERENCES questao(id),
  id_comentario INTEGER REFERENCES comentario(id),
  id_resposta INTEGER REFERENCES resposta(id)
);

CREATE TABLE historico_interacao(
  id SERIAL PRIMARY KEY,
  texto TEXT NOT NULL,
  data TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  id_questao INTEGER REFERENCES questao(id),
  id_comentario INTEGER REFERENCES comentario(id),
  id_resposta INTEGER REFERENCES resposta(id)
  );


CREATE TABLE utilizador_ativo_notificacao(
  id_utilizador INTEGER NOT NULL REFERENCES utilizador_ativo(id) ON UPDATE CASCADE,
  id_notificacao INTEGER NOT NULL REFERENCES notificacao(id) ON UPDATE CASCADE,
  dataLida TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
  PRIMARY KEY (id_utilizador, id_notificacao)
);

CREATE TABLE utilizador_ativo_medalha(
  id_medalha INTEGER NOT NULL REFERENCES medalha(id) ON UPDATE CASCADE,
  id_utilizador INTEGER NOT NULL REFERENCES utilizador_ativo(id) ON UPDATE CASCADE,
  PRIMARY KEY (id_utilizador, id_medalha)
);

CREATE TABLE questao_seguida(
  id_utilizador INTEGER NOT NULL REFERENCES utilizador_ativo(id) ON UPDATE CASCADE,
  id_questao INTEGER NOT NULL REFERENCES questao(id) ON UPDATE CASCADE,
  PRIMARY KEY (id_utilizador, id_questao)
);

CREATE TABLE questao_avaliada(
  id_utilizador INTEGER NOT NULL REFERENCES utilizador_ativo(id) ON UPDATE CASCADE,
  id_questao INTEGER NOT NULL REFERENCES questao(id) ON UPDATE CASCADE,
  PRIMARY KEY (id_utilizador, id_questao)
);

CREATE TABLE resposta_avaliada(
  id_utilizador INTEGER NOT NULL REFERENCES utilizador_ativo(id) ON UPDATE CASCADE,
  id_resposta INTEGER NOT NULL REFERENCES resposta(id) ON UPDATE CASCADE,
  PRIMARY KEY (id_utilizador, id_resposta)
);

CREATE TABLE etiqueta(
  id SERIAL PRIMARY KEY,
  nome TEXT NOT NULL
);

CREATE TABLE questao_etiqueta(
  id_etiqueta INTEGER NOT NULL REFERENCES etiqueta(id) ON UPDATE CASCADE,
  id_questao INTEGER NOT NULL REFERENCES questao(id) ON UPDATE CASCADE,
  PRIMARY KEY (id_questao, id_etiqueta)
);

/*

  TRIGGERS START HERE

*/

DROP INDEX IF EXISTS pesquisa_questao;
DROP INDEX IF EXISTS auto_interacao_comentario;


CREATE OR REPLACE FUNCTION auto_interacao_resposta() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS(SELECT * FROM questao WHERE NEW.id_questao = id_questao AND NEW.autor = autor) THEN
  RAISE EXCEPTION 'O utilizador não pode responder à própria questão!';
  END IF;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER auto_interacao_resposta
  BEFORE INSERT ON resposta
  FOR EACH ROW
  EXECUTE PROCEDURE auto_interacao_resposta();


CREATE FUNCTION auto_interacao_comentario() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS(SELECT * FROM questao WHERE NEW.id_questao = id_questao AND NEW.autor = autor) THEN
  RAISE EXCEPTION 'O utilizador não pode comentar à própria questão!';
  END IF;
  IF EXISTS(SELECT * FROM resposta WHERE NEW.id_resposta = id_resposta AND NEW.autor = autor) THEN
  RAISE EXCEPTION 'O utilizador não pode comentar à própria responder!';
  END IF;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER auto_interacao_comentario
  BEFORE INSERT ON comentario
  FOR EACH ROW
  EXECUTE PROCEDURE auto_interacao_comentario();


/*
  TRIGGER PARA PESQUISA EM QUESTÕES
*/

ALTER TABLE questao
ADD COLUMN IF NOT EXISTS tsvectors TSVECTOR;

CREATE OR REPLACE FUNCTION atualiza_tsvector_conteudo_questao() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = (
            setweight(to_tsvector('portuguese', NEW.titulo), 'A'),
            setweight(to_tsvector('portuguese', NEW.texto), 'B')
        );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW.titulo <> OLD.titulo OR NEW.titulo <> NEW.texto) THEN
            NEW.tsvectors = (
                setweight(to_tsvector('portuguese', NEW.titulo), 'A'),
                setweight(to_tsvector('portuguese', NEW.texto), 'B')
            );
        END IF;
    END IF;
    RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER pesquisa_questao
    BEFORE INSERT OR UPDATE ON questao
    FOR EACH ROW
    EXECUTE PROCEDURE atualiza_tsvector_conteudo_questao();

CREATE INDEX pesquisa_questao ON questao USING GIN (tsvectors);
