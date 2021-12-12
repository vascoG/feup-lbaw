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
DROP TABLE IF EXISTS utilizador_ativo_etiqueta CASCADE;


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
  e_mail TEXT NOT NULL UNIQUE,
  data_nascimento DATE NOT NULL CHECK (data_nascimento < now()),
  id_palavra_passe INTEGER UNIQUE NOT NULL REFERENCES palavra_passe(id) ON UPDATE CASCADE,
  moderador BOOLEAN NOT NULL,
  administrador BOOLEAN NOT NULL
);

CREATE TABLE utilizador_ativo(
  id SERIAL PRIMARY KEY,
  id_utilizador INTEGER UNIQUE NOT NULL REFERENCES utilizador(id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE utilizador_banido(
  id SERIAL PRIMARY KEY,
  id_utilizador INTEGER UNIQUE NOT NULL REFERENCES utilizador(id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE apelo_desbloqueio(
  id SERIAL PRIMARY KEY,
  motivo TEXT NOT NULL,
  id_utilizador INTEGER NOT NULL REFERENCES utilizador_banido(id) ON UPDATE CASCADE ON DELETE CASCADE
);

CREATE TABLE medalha(
  id SERIAL PRIMARY KEY,
  nome TEXT UNIQUE NOT NULL,
  imagem TEXT UNIQUE NOT NULL
);

CREATE TABLE questao(
  id SERIAL PRIMARY KEY,
  texto TEXT NOT NULL,
  data_publicacao TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL CHECK (data_publicacao <= now()),
  autor INTEGER REFERENCES utilizador_ativo(id) ON DELETE SET NULL,
  titulo TEXT NOT NULL
);

CREATE TABLE resposta(
  id SERIAL PRIMARY KEY,
  texto TEXT NOT NULL,
  data_publicacao TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL CHECK (data_publicacao <= now()),
  autor INTEGER REFERENCES utilizador_ativo(id) ON DELETE SET NULL,
  id_questao INTEGER NOT NULL REFERENCES questao(id),
  resposta_aceite BOOLEAN NOT NULL
);

CREATE TABLE comentario(
  id SERIAL PRIMARY KEY,
  texto TEXT NOT NULL,
  data_publicacao TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL CHECK (data_publicacao <= now()),
  autor INTEGER REFERENCES utilizador_ativo(id) ON DELETE SET NULL,
  id_questao INTEGER REFERENCES questao(id),
  id_resposta INTEGER REFERENCES resposta(id)
);

CREATE TABLE notificacao(
  id SERIAL PRIMARY KEY,
  texto TEXT NOT NULL,
  data_emissao TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL CHECK (data_emissao <= now()),
  id_questao INTEGER REFERENCES questao(id),
  id_comentario INTEGER REFERENCES comentario(id),
  id_resposta INTEGER REFERENCES resposta(id)
);

CREATE TABLE historico_interacao(
  id SERIAL PRIMARY KEY,
  texto TEXT NOT NULL,
  data_edicao TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL CHECK (data_edicao <= now()),
  id_questao INTEGER REFERENCES questao(id),
  id_comentario INTEGER REFERENCES comentario(id),
  id_resposta INTEGER REFERENCES resposta(id)
);


CREATE TABLE utilizador_ativo_notificacao(
  id_utilizador INTEGER NOT NULL REFERENCES utilizador_ativo(id) ON UPDATE CASCADE ON DELETE CASCADE,
  id_notificacao INTEGER NOT NULL REFERENCES notificacao(id) ON UPDATE CASCADE,
  data_lida TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL CHECK (data_lida <= now()),
  PRIMARY KEY (id_utilizador, id_notificacao)
);

CREATE TABLE utilizador_ativo_medalha(
  id_medalha INTEGER NOT NULL REFERENCES medalha(id) ON UPDATE CASCADE,
  id_utilizador INTEGER NOT NULL REFERENCES utilizador_ativo(id) ON UPDATE CASCADE ON DELETE CASCADE,
  PRIMARY KEY (id_utilizador, id_medalha)
);

CREATE TABLE questao_seguida(
  id_utilizador INTEGER NOT NULL REFERENCES utilizador_ativo(id) ON UPDATE CASCADE ON DELETE CASCADE,
  id_questao INTEGER NOT NULL REFERENCES questao(id) ON UPDATE CASCADE,
  PRIMARY KEY (id_utilizador, id_questao)
);

CREATE TABLE questao_avaliada(
  id_utilizador INTEGER NOT NULL REFERENCES utilizador_ativo(id) ON UPDATE CASCADE ON DELETE CASCADE,
  id_questao INTEGER NOT NULL REFERENCES questao(id) ON UPDATE CASCADE ON DELETE CASCADE,
  PRIMARY KEY (id_utilizador, id_questao)
);

CREATE TABLE resposta_avaliada(
  id_utilizador INTEGER NOT NULL REFERENCES utilizador_ativo(id) ON UPDATE CASCADE ON DELETE CASCADE,
  id_resposta INTEGER NOT NULL REFERENCES resposta(id) ON UPDATE CASCADE ON DELETE CASCADE,
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

CREATE TABLE utilizador_ativo_etiqueta(
  id_utilizador INTEGER NOT NULL REFERENCES utilizador_ativo(id) ON UPDATE CASCADE ON DELETE CASCADE,
  id_etiqueta INTEGER NOT NULL REFERENCES etiqueta(id) ON UPDATE CASCADE ON DELETE CASCADE,
  PRIMARY KEY (id_utilizador, id_etiqueta)
);

/*

  VISTAS COMECAM AQUI

*/

DROP MATERIALIZED VIEW IF EXISTS gosto_questoes;
DROP MATERIALIZED VIEW IF EXISTS gosto_respostas;
DROP MATERIALIZED VIEW IF EXISTS historico_questao;
DROP MATERIALIZED VIEW IF EXISTS historico_resposta;
DROP MATERIALIZED VIEW IF EXISTS historico_comentario;

CREATE MATERIALIZED VIEW gosto_questoes AS
  SELECT id_questao, COUNT(*) AS n_gosto
  FROM questao_avaliada
  GROUP BY id_questao;

CREATE MATERIALIZED VIEW gosto_respostas AS
  SELECT id_resposta, COUNT(*) AS n_gosto
  FROM resposta_avaliada
  GROUP BY id_resposta;

CREATE MATERIALIZED VIEW historico_questao AS
  SELECT id, texto, data_edicao, id_questao
  FROM historico_interacao
  WHERE id_questao IS NOT NULL;

CREATE MATERIALIZED VIEW historico_resposta AS
  SELECT id, texto, data_edicao, id_resposta
  FROM historico_interacao
  WHERE id_resposta IS NOT NULL;

CREATE MATERIALIZED VIEW historico_comentario AS
  SELECT id, texto, data_edicao, id_comentario
  FROM historico_interacao
  WHERE id_comentario IS NOT NULL;

/*

  TRIGGERS COMECAM AQUI

*/
DROP TRIGGER IF EXISTS auto_interacao_resposta ON resposta;
DROP TRIGGER IF EXISTS auto_interacao_comentario ON comentario;
DROP TRIGGER IF EXISTS pesquisa_questao ON questao;
DROP TRIGGER IF EXISTS notifica_utilizador ON notificacao;
DROP TRIGGER IF EXISTS atualiza_vista_gosto_questoes ON questao_avaliada;
DROP TRIGGER IF EXISTS atualiza_vista_gosto_respostas ON resposta_avaliada;
DROP TRIGGER IF EXISTS verifica_data_resposta ON resposta;
DROP TRIGGER IF EXISTS verifica_data_comentario_resposta ON comentario;
DROP TRIGGER IF EXISTS verifica_data_comentario_questao ON comentario;
DROP TRIGGER IF EXISTS apenas_um_tipo_interacao ON historico_interacao;
DROP TRIGGER IF EXISTS apenas_um_tipo_interacao ON notificacao;
DROP TRIGGER IF EXISTS valor_autor_insere ON questao;
DROP TRIGGER IF EXISTS valor_autor_insere ON notificacao;
DROP TRIGGER IF EXISTS valor_autor_insere ON comentario;
DROP TRIGGER IF EXISTS valor_questao_atualiza ON questao;
DROP TRIGGER IF EXISTS valor_resposta_atualiza ON resposta;
DROP TRIGGER IF EXISTS valor_comentario_atualiza ON comentario;
DROP TRIGGER IF EXISTS atualiza_historicos ON historico_interacao;
DROP TRIGGER IF EXISTS verifica_nr_apelos ON apelo_desbloqueio;
DROP TRIGGER IF EXISTS pesquisa_etiqueta ON etiqueta;
DROP TRIGGER IF EXISTS resposta_historico on resposta;
DROP TRIGGER IF EXISTS questao_historico on questao;
DROP TRIGGER IF EXISTS comentario_historico on comentario;


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

/*
  TRIGGER PARA VERIFICAR SE O TANTO A NOTIFICAÇÃO COMO O HISTÓRICO SE REFEREM APENAS A UM TIPO DE INTERAÇÃO
*/

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

/*
  TRIGGER QUE VERIFICA SE O AUTOR DAS INTERAÇÕES NÃO É NULO DURANTE A CRIAÇÃO
*/

CREATE OR REPLACE FUNCTION valor_autor_insere() RETURNS TRIGGER AS $$
BEGIN
  IF NEW.autor IS NULL THEN
    RAISE EXCEPTION 'Interacao possuí autor nulo!';
    RETURN NULL; 
  END IF;
  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER valor_autor_insere
  BEFORE INSERT ON questao
  FOR EACH ROW
  EXECUTE PROCEDURE valor_autor_insere();

CREATE TRIGGER valor_autor_insere
  BEFORE INSERT ON resposta
  FOR EACH ROW
  EXECUTE PROCEDURE valor_autor_insere();

CREATE TRIGGER valor_autor_insere
  BEFORE INSERT ON comentario
  FOR EACH ROW
  EXECUTE PROCEDURE valor_autor_insere();

/*
  TRIGGER QUE VERIFICA SE UMA QUESTÃO COM AUTOR ANONIMO É EDITADA
*/

CREATE OR REPLACE FUNCTION valor_questao_atualiza() RETURNS TRIGGER AS $$
BEGIN
  IF OLD.autor IS NULL THEN
    RAISE EXCEPTION 'Alteracao em questao sem autor identificado';
  END IF;
  IF NEW.autor IS NULL THEN
    IF NEW.id = OLD.id AND NEW.texto = OLD.texto AND NEW.data_publicacao = OLD.data_publicacao AND NEW.titulo = OLD.titulo THEN
      RETURN NEW;
    END IF;
    RAISE EXCEPTION 'Alteracao em questao sem autor identificado';
    RETURN NULL;
  END IF;
  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER valor_questao_atualiza
  BEFORE UPDATE ON questao
  FOR EACH ROW
  EXECUTE PROCEDURE valor_questao_atualiza();

/*
  TRIGGER QUE VERIFICA SE UMA RESPOSTA COM AUTOR ANONIMO É EDITADA
*/

CREATE OR REPLACE FUNCTION valor_resposta_atualiza() RETURNS TRIGGER AS $$
BEGIN
  IF OLD.autor IS NULL THEN
    RAISE EXCEPTION 'Alteracao em resposta sem autor identificado';
  END IF;
  IF NEW.autor IS NULL THEN
    IF NEW.id = OLD.id AND NEW.texto = OLD.texto AND NEW.data_publicacao = OLD.data_publicacao AND NEW.id_questao = OLD.id_questao AND NEW.resposta_aceite = OLD.resposta_aceite THEN
      RETURN NEW;
    END IF;
    RAISE EXCEPTION 'Alteracao em resposta sem autor identificado';
    RETURN NULL;
  END IF;
  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER valor_resposta_atualiza
  BEFORE UPDATE ON resposta
  FOR EACH ROW
  EXECUTE PROCEDURE valor_resposta_atualiza();

/*
  TRIGGER QUE VERIFICA SE UMA COMENTÁRIO COM AUTOR ANONIMO É EDITADA
*/

CREATE OR REPLACE FUNCTION valor_comentario_atualiza() RETURNS TRIGGER AS $$
BEGIN
  IF OLD.autor IS NULL THEN
    RAISE EXCEPTION 'Alteracao em comentario sem autor identificado';
  END IF;
  IF NEW.autor IS NULL THEN
    IF NEW.id = OLD.id AND NEW.texto = OLD.texto AND NEW.data_publicacao = OLD.data_publicacao AND NEW.id_questao IS NOT DISTINCT FROM OLD.id_questao AND NEW.id_resposta IS NOT DISTINCT FROM OLD.id_resposta THEN
      RETURN NEW;
    END IF;
    RAISE EXCEPTION 'Alteracao em comentario sem autor identificado';
    RETURN NULL;
  END IF;
  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER valor_comentario_atualiza
  BEFORE UPDATE ON comentario
  FOR EACH ROW
  EXECUTE PROCEDURE valor_comentario_atualiza();

/*
  TRIGGER QUE ATUALIZA AS VISTAS DO HISTORICO DE INTERAÇÕES
*/

CREATE OR REPLACE FUNCTION atualiza_historicos() RETURNS TRIGGER AS $$
BEGIN
  REFRESH MATERIALIZED VIEW historico_questao;
  REFRESH MATERIALIZED VIEW historico_resposta;
  REFRESH MATERIALIZED VIEW historico_comentario;
  RETURN NULL;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER atualiza_historicos
  AFTER INSERT OR UPDATE ON historico_interacao
  FOR EACH STATEMENT
  EXECUTE PROCEDURE atualiza_historicos();

CREATE OR REPLACE FUNCTION resposta_historico() RETURNS TRIGGER AS $$
BEGIN
  INSERT INTO historico_interacao(texto,id_resposta) VALUES (OLD.texto,OLD.id) ;

  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER resposta_historico
  AFTER UPDATE ON resposta
  FOR EACH ROW
  EXECUTE PROCEDURE resposta_historico();

CREATE OR REPLACE FUNCTION questao_historico() RETURNS TRIGGER AS $$
BEGIN
  INSERT INTO historico_interacao(texto,id_questao) VALUES (OLD.texto,OLD.id) ;

  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER questao_historico
  AFTER UPDATE ON questao
  FOR EACH ROW
  EXECUTE PROCEDURE questao_historico();

CREATE OR REPLACE FUNCTION comentario_historico() RETURNS TRIGGER AS $$
BEGIN
  INSERT INTO historico_interacao(texto,id_comentario) VALUES (OLD.texto,OLD.id) ;

  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER comentario_historico
  AFTER UPDATE ON comentario
  FOR EACH ROW
  EXECUTE PROCEDURE comentario_historico(); 

/*
  TRIGGER QUE VERIFICA SE O NÚMERO DE APELOS PARA CADA UTILIZADOR ESTÁ ENTRE 0 E 3
*/

CREATE OR REPLACE FUNCTION verifica_nr_apelos() RETURNS TRIGGER AS $$
DECLARE
  nr_apelo INTEGER;
BEGIN
  SELECT count(*) INTO nr_apelo
  FROM apelo_desbloqueio
  WHERE id_utilizador = NEW.id_utilizador
  GROUP BY id_utilizador;
  IF nr_apelo + 1 > 3 THEN
    RAISE EXCEPTION 'Mais apelos que permitido';
    RETURN NULL;
  END IF;
  RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER verifica_nr_apelos
  BEFORE INSERT ON apelo_desbloqueio
  FOR EACH ROW
  EXECUTE PROCEDURE verifica_nr_apelos();

/*
  PERMITE A PESQUISA NO TEXTO DE ETIQUETAS
*/

ALTER TABLE etiqueta
ADD COLUMN IF NOT EXISTS tsvectors TSVECTOR;

CREATE OR REPLACE FUNCTION atualiza_tsvector_etiqueta() RETURNS TRIGGER AS $$
BEGIN
    IF TG_OP = 'INSERT' THEN
        NEW.tsvectors = to_tsvector('portuguese', NEW.nome);
    END IF;
    IF TG_OP = 'UPDATE' THEN
        IF (NEW.nome <> OLD.nome) THEN
            NEW.tsvectors = to_tsvector('portuguese', NEW.nome);
        END IF;
    END IF;
    RETURN NEW;
END $$
LANGUAGE plpgsql;

CREATE TRIGGER pesquisa_etiqueta
    BEFORE INSERT OR UPDATE ON etiqueta
    FOR EACH ROW
    EXECUTE PROCEDURE atualiza_tsvector_etiqueta();

/*

  Indices comecam aqui

*/

DROP INDEX IF EXISTS pesquisa_questao;
DROP INDEX IF EXISTS pesquisa_etiqueta;
DROP INDEX IF EXISTS numero_gosto_questoes;
DROP INDEX IF EXISTS numero_gosto_respostas;
DROP INDEX IF EXISTS data_publicacao_questao;
DROP INDEX IF EXISTS agrupa_historico_questao;
DROP INDEX IF EXISTS agrupa_historico_resposta;
DROP INDEX IF EXISTS agrupa_historico_comentario;

CREATE INDEX pesquisa_questao ON questao USING GIN (tsvectors);
CREATE INDEX pesquisa_etiqueta ON etiqueta USING GIN (tsvectors);
CREATE INDEX numero_gosto_questao ON gosto_questoes USING BTREE (n_gosto);
CREATE INDEX numero_gosto_resposta ON gosto_respostas USING BTREE (n_gosto);
CREATE INDEX data_publicacao_questao ON questao USING BTREE (data_publicacao);
CREATE INDEX apelo_utilizador_banido ON apelo_desbloqueio USING HASH (id_utilizador);
CREATE INDEX agrupa_historico_questao ON historico_questao USING BTREE(id_questao);
CLUSTER historico_questao USING agrupa_historico_questao;

CREATE INDEX agrupa_historico_resposta ON historico_resposta USING BTREE(id_resposta);
CLUSTER historico_resposta USING agrupa_historico_resposta;

CREATE INDEX agrupa_historico_comentario ON historico_comentario USING BTREE(id_comentario);
CLUSTER historico_comentario USING agrupa_historico_comentario;

/*
  POPULAÇÃO DA BASE DE DADOS
*/

INSERT INTO palavra_passe(id,palavra_passe,palavra_passe_salt)
VALUES (generate_series(1,1010),md5(random()::text),md5(random()::text));
INSERT INTO utilizador(id,nome_utilizador,nome,e_mail,data_nascimento,id_palavra_passe,moderador,administrador)
VALUES (generate_series(1,1000),md5(random()::text),md5(random()::text),md5(random()::text), (timestamp '1972-01-01 00:00:00' + random() * (now() - timestamp '1972-01-01 00:00:00')) :: DATE, generate_series(1,1000),FALSE,FALSE);
INSERT INTO utilizador(id,nome_utilizador,nome,e_mail,data_nascimento,id_palavra_passe,moderador,administrador)
VALUES
(1001,'vasco8','Vasco Gomes','vascogomes@gmail.pt','2001-02-15',1001,FALSE,TRUE),
(1002,'mari75','Maria Santos','mariasantos@gmail.pt','2001-04-16',1002,TRUE,FALSE),
(1003,'marci_24','Marcia Carvalho','marcia@gmail.pt','1998-10-29',1003,TRUE,FALSE),
(1004,'m_monteiro','Mariana Monteiro','mmonteiro@gmail.pt','2001-05-04',1004,FALSE,TRUE),
(1005,'francisco1','Francisco Oliveira','francisco1@gmail.pt','2001-06-24',1005,FALSE,TRUE),
(1006,'j_rodrigo','João Rodrigo','joaor@gmail.pt','1998-05-30',1006,FALSE,TRUE),
(1007,'leonor2001','Leonor Castro','leonor2001@gmail.pt','1990-04-16',1007,TRUE,FALSE),
(1008,'mariapinto','Maria Pinto','mariap@gmail.pt','1995-11-19',1008,TRUE,FALSE),
(1009,'martim22','Martim Castro','martimcastro@gmail.pt','1997-09-22',1009,TRUE,FALSE),
(1010,'carla_mirra','Carla Mirra','carlam@gmail.pt','2002-07-25',1010,TRUE,FALSE);
INSERT INTO utilizador_ativo(id,id_utilizador)
VALUES (generate_series(1,1010),generate_series(1,1010));
INSERT INTO utilizador_banido(id,id_utilizador)
VALUES (generate_series(1,10),generate_series(1,10));
INSERT INTO apelo_desbloqueio(id,motivo,id_utilizador)
VALUES (generate_series(1,10),md5(random()::text),generate_series(1,10));
INSERT INTO medalha(id,nome,imagem)
VALUES (generate_series(1,10),md5(random()::text),md5(random()::text));
INSERT INTO  utilizador_ativo_medalha(id_medalha,id_utilizador)
VALUES (random()*9+1,generate_series(1,1010));
INSERT INTO questao (id,texto,autor,titulo)
VALUES (generate_series(1,1000),md5(random()::text),random()*199+1,md5(random()::text));
INSERT INTO questao_seguida(id_utilizador, id_questao)
VALUES (generate_series(1,1010),random()*999+1);
INSERT INTO resposta (id,texto,autor,id_questao,resposta_aceite)
VALUES (generate_series(1,1000),md5(random()::text),random()*199+201,random()*999+1,FALSE);
INSERT INTO comentario (id,texto,autor,id_questao)
VALUES (generate_series(1,500),md5(random()::text),random()*500+401,random()*999+1);
INSERT INTO comentario (id,texto,autor,id_resposta)
VALUES (generate_series(501,1000),md5(random()::text),random()*500+401,random()*999+1);
INSERT INTO notificacao(id,texto,id_questao)
VALUES (generate_series(1,1010),md5(random()::text),random()*999+1);
INSERT INTO etiqueta(id,nome)
VALUES (generate_series(1,10),md5(random()::text));
INSERT INTO questao_etiqueta(id_etiqueta, id_questao)
VALUES (random()*9+1,generate_series(1,1000));
INSERT INTO questao_avaliada(id_utilizador,id_questao)
VALUES (generate_series(1,1000),random()*999+1);
INSERT INTO resposta_avaliada(id_utilizador,id_resposta)
VALUES (generate_series(1,1000),random()*999+1);
INSERT INTO utilizador_ativo_etiqueta(id_utilizador,id_etiqueta)
VALUES (generate_series(1,1000),random()*9+1);
INSERT INTO historico_interacao(id,texto,id_resposta)
VALUES (generate_series(1,100),md5(random()::text),random()*999+1);
INSERT INTO historico_interacao(id,texto,id_questao)
VALUES (generate_series(101,200),md5(random()::text),random()*999+1);
INSERT INTO historico_interacao(id,texto,id_comentario)
VALUES (generate_series(201,300),md5(random()::text),random()*999+1);