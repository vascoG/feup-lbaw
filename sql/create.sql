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
  data_lida TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL,
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

  VISTAS COMECAM AQUI

*/

DROP MATERIALIZED VIEW IF EXISTS gosto_questoes;
DROP MATERIALIZED VIEW IF EXISTS gosto_respostas;

CREATE MATERIALIZED VIEW gosto_questoes AS
  SELECT id_questao, COUNT(*) AS n_gosto
  FROM questao_avaliada
  GROUP BY id_questao;

CREATE MATERIALIZED VIEW gosto_respostas AS
  SELECT id_resposta, COUNT(*) AS n_gosto
  FROM resposta_avaliada
  GROUP BY id_resposta;

/*

  TRIGGERS COMECAM AQUI

*/
DROP TRIGGER IF EXISTS auto_interacao_resposta ON resposta;
DROP TRIGGER IF EXISTS auto_interacao_comentario ON comentario;
DROP TRIGGER IF EXISTS notifica_utilizador ON notificacao;
DROP TRIGGER IF EXISTS atualiza_vista_gosto_questoes ON questao_avaliada;
DROP TRIGGER IF EXISTS atualiza_vista_gosto_respostas ON resposta_avaliada;
DROP TRIGGER IF EXISTS verifica_data_resposta ON resposta;
DROP TRIGGER IF EXISTS verifica_data_comentario_resposta ON comentario;
DROP TRIGGER IF EXISTS verifica_data_comentario_questao ON comentario;
DROP TRIGGER IF EXISTS apenas_um_tipo_interacao ON historico_interacao;
DROP TRIGGER IF EXISTS apenas_um_tipo_interacao ON notificacao;


/*
  TRIGGER QUE IMPEDE O AUTOR DE UMA RESPOSTA DE INTERAGIR COM A MESMA
*/

CREATE OR REPLACE FUNCTION auto_interacao_resposta() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS(SELECT * FROM questao WHERE NEW.id_questao = id AND NEW.autor = autor) THEN
  RAISE EXCEPTION 'O utilizador não pode responder à própria questão!';
  END IF;
  RETURN NEW;
END
$BODY$
LANGUAGE plpgsql;

CREATE TRIGGER auto_interacao_resposta
  BEFORE INSERT ON resposta
  FOR EACH ROW
  EXECUTE PROCEDURE auto_interacao_resposta();


CREATE OR REPLACE FUNCTION auto_interacao_comentario() RETURNS TRIGGER AS
$BODY$
BEGIN
  IF EXISTS(SELECT * FROM questao WHERE NEW.id_questao = id AND NEW.autor = autor) THEN
  RAISE EXCEPTION 'O utilizador não pode comentar a própria questão!';
  END IF;
  IF EXISTS(SELECT * FROM resposta WHERE NEW.id_resposta = id AND NEW.autor = autor) THEN
  RAISE EXCEPTION 'O utilizador não pode comentar a própria resposta!';
  END IF;
  RETURN NEW;
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
            setweight(to_tsvector('portuguese', NEW.titulo), 'A') ||
            setweight(to_tsvector('portuguese', NEW.texto), 'B')
        );
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW.titulo <> OLD.titulo OR NEW.texto <> OLD.texto) THEN
            NEW.tsvectors = (
                setweight(to_tsvector('portuguese', NEW.titulo), 'A') ||
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

/*
  TRIGGER QUE NOTIFICA TODOS OS UTILIZADORES QUANDO UMA NOTIFICAÇÃO É CRIADA
*/

CREATE OR REPLACE FUNCTION atualiza_lista_notificacoes() RETURNS TRIGGER AS $$
BEGIN
  INSERT INTO utilizador_ativo_notificacao (id_utilizador, id_notificacao)
  SELECT questao_seguida.id_utilizador, NEW.id
  FROM questao_seguida
  WHERE questao_seguida.id_questao = NEW.id_questao;

  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER notifica_utilizador
    AFTER INSERT ON notificacao
    FOR EACH ROW
    WHEN (NEW.id_questao IS NOT NULL)
    EXECUTE PROCEDURE atualiza_lista_notificacoes();

/*
  TRIGGER PARA ATUALIZAR VIEW MATERIALIZADA DOS LIKES EM QUESTOES
*/

CREATE OR REPLACE FUNCTION atualiza_vista_gosto_questoes() RETURNS TRIGGER AS $$
BEGIN
  REFRESH MATERIALIZED VIEW gosto_questoes;
  RETURN NULL;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER atualiza_vista_gosto_questoes
  AFTER INSERT ON questao_avaliada
  FOR EACH STATEMENT
  EXECUTE PROCEDURE atualiza_vista_gosto_questoes();

/*
  TRIGGER PARA ATUALIZAR VIEW MATERIALIZADA DOS LIKES EM RESPOSTAS
*/

CREATE OR REPLACE FUNCTION atualiza_vista_gosto_respostas() RETURNS TRIGGER AS $$
BEGIN
  REFRESH MATERIALIZED VIEW gosto_respostas;
  RETURN NULL;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER atualiza_vista_gosto_respostas
  AFTER INSERT ON resposta_avaliada
  FOR EACH STATEMENT
  EXECUTE PROCEDURE atualiza_vista_gosto_respostas();

/*
  TRIGGER PARA VERIFICAR SE A RESPOSTA É MAIS RECENTE QUE A PERGUNTA
*/

CREATE OR REPLACE FUNCTION verifica_data_resposta() RETURNS TRIGGER AS $$
DECLARE
  data_questao TIMESTAMP;
BEGIN
  SELECT data_publicacao INTO data_questao
  FROM questao
  WHERE NEW.id_questao = questao.id;

  IF data_questao > NEW.data_publicacao THEN
    RAISE EXCEPTION 'erro_data_reposta -> %', NEW.data_publicacao
      USING HINT = "Data de publicacao da resposta mais antiga que a da pergunta";
    RETURN NULL;
  END IF;
  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER verifica_data_resposta
  BEFORE INSERT ON resposta
  FOR EACH ROW
  EXECUTE PROCEDURE verifica_data_resposta();

/*
  TRIGGER PARA VERIFICAR SE O COMENTARIO É MAIS RECENTE QUE A RESPOSTA
*/

CREATE OR REPLACE FUNCTION verifica_data_comentario_resposta() RETURNS TRIGGER AS $$
DECLARE
  data_resposta TIMESTAMP;
BEGIN
  SELECT data_publicacao INTO data_resposta
  FROM resposta
  WHERE NEW.id_resposta = resposta.id;

  IF data_resposta > NEW.data_publicacao THEN
    RAISE EXCEPTION 'erro_data_reposta -> %', NEW.data_publicacao
      USING HINT = "Data de publicacao do comentario mais antigo que o da resposta";
    RETURN NULL;
  END IF;
  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER verifica_data_comentario_resposta
  BEFORE INSERT ON comentario
  FOR EACH ROW
  WHEN (NEW.id_resposta IS NOT NULL)
  EXECUTE PROCEDURE verifica_data_comentario_resposta();

/*
  TRIGGER PARA VERIFICAR SE O COMENTARIO É MAIS RECENTE QUE A QUESTAO
*/

CREATE OR REPLACE FUNCTION verifica_data_comentario_questao() RETURNS TRIGGER AS $$
DECLARE
  data_questao TIMESTAMP;
BEGIN
  SELECT data_publicacao INTO data_questao
  FROM questao
  WHERE NEW.id_questao = questao.id;

  IF data_questao > NEW.data_publicacao THEN
    RAISE EXCEPTION 'erro_data_reposta -> %', NEW.data_publicacao
      USING HINT = "Data de publicacao do comentario mais antigo que o da questao";
    RETURN NULL;
  END IF;
  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER verifica_data_comentario_questao
  BEFORE INSERT ON comentario
  FOR EACH ROW
  WHEN (NEW.id_questao IS NOT NULL)
  EXECUTE PROCEDURE verifica_data_comentario_questao();

CREATE OR REPLACE FUNCTION apenas_um_tipo_interacao() RETURNS TRIGGER AS $$
BEGIN
  IF (NEW.id_questao IS NOT NULL AND NEW.id_resposta IS NULL AND NEW.id_comentario IS NULL) OR (NEW.id_resposta IS NOT NULL AND NEW.id_questao IS NULL AND NEW.id_comentario IS NULL) OR (NEW.id_comentario IS NOT NULL AND NEW.id_questao IS NULL AND NEW.id_resposta IS NULL) THEN
    RETURN NEW;
  END IF;
  RAISE EXCEPTION 'Erro input interacao'
    USING HINT = "Interacao possui multiplas referências";
  RETURN NULL; 
END $$
LANGUAGE plpgsql;

CREATE TRIGGER apenas_um_tipo_historico
  BEFORE INSERT ON historico_interacao
  FOR EACH ROW
  EXECUTE PROCEDURE apenas_um_tipo_interacao();

CREATE TRIGGER apenas_um_tipo_interacao
  BEFORE INSERT ON notificacao
  FOR EACH ROW
  EXECUTE PROCEDURE apenas_um_tipo_interacao();

CREATE OR REPLACE FUNCTION


/*

  Indices comecam aqui

*/

DROP INDEX IF EXISTS pesquisa_questao;
DROP INDEX IF EXISTS numero_gosto_questoes;
DROP INDEX IF EXISTS numero_gosto_respostas;

CREATE INDEX pesquisa_questao ON questao USING GIN (tsvectors);
CREATE INDEX numero_gosto_questao ON gosto_questoes USING BTREE (n_gosto);
CREATE INDEX numero_gosto_resposta ON gosto_respostas USING BTREE (n_gosto);
