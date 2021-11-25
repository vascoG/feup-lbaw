SET search_path TO lbaw2191;

DROP TABLE IF EXISTS utilizador CASCADE;
DROP TABLE IF EXISTS utilizador_ativo CASCADE;
DROP TABLE IF EXISTS utilizador_banido CASCADE;
DROP TABLE IF EXISTS apelo_desbloqueio CASCADE;
DROP TABLE IF EXISTS medalha CASCADE;
DROP TABLE IF EXISTS notificacao CASCADE;
DROP TABLE IF EXISTS interacao_utilizador CASCADE;
DROP TABLE IF EXISTS historico_interacao CASCADE;
DROP TABLE IF EXISTS resposta CASCADE;
DROP TABLE IF EXISTS comentario CASCADE;
DROP TABLE IF EXISTS questao CASCADE;
DROP TABLE IF EXISTS utilizador_ativo_notificacao CASCADE;
DROP TABLE IF EXISTS utilizador_ativo_medalha CASCADE;
DROP TABLE IF EXISTS questao_seguida CASCADE;
DROP TABLE IF EXISTS questao_avaliada CASCADE;
DROP TABLE IF EXISTS resposta_avaliada CASCADE;
DROP TABLE IF EXISTS tag CASCADE;
DROP TABLE IF EXISTS questao_tag CASCADE;
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

CREATE TABLE notificacao(
  id SERIAL PRIMARY KEY,
  texto TEXT NOT NULL,
  data TIMESTAMP WITH TIME ZONE NOT NULL CONSTRAINT data_notificao_ck CHECK (data <= now()),
  interacao INTEGER REFERENCES interacao_utilizador(id) ON UPDATE CASCADE
);

CREATE TABLE interacao_utilizador(
  id SERIAL PRIMARY KEY,
  texto TEXT UNIQUE NOT NULL,
  data_publicacao TIMESTAMP WITH TIME ZONE DEFAULT now() NOT NULL CONSTRAINT data_interacao_ck CHECK (data_publicacao <= now()),
  autor INTEGER REFERENCES utilizador_ativo(id) ON UPDATE CASCADE
);

CREATE TABLE historico_interacao(
  id SERIAL PRIMARY KEY,
  versao INTEGER UNIQUE NOT NULL,
  texto TEXT NOT NULL,
  data TIMESTAMP WITH TIME ZONE NOT NULL CONSTRAINT data_hostorico CHECK (data <= now()),
  id_interacao INTEGER NOT NULL REFERENCES interacao_utilizador(id) ON UPDATE CASCADE
);

CREATE TABLE resposta(
  id SERIAL PRIMARY KEY,
  id_interacao INTEGER UNIQUE NOT NULL REFERENCES interacao_utilizador(id) ON UPDATE CASCADE
);

CREATE TABLE comentario(
  id SERIAL PRIMARY KEY,
  id_interacao INTEGER UNIQUE NOT NULL REFERENCES interacao_utilizador(id) ON UPDATE CASCADE
);

CREATE TABLE questao(
  id SERIAL PRIMARY KEY,
  id_interacao INTEGER UNIQUE NOT NULL REFERENCES interacao_utilizador(id) ON UPDATE CASCADE,
  titulo TEXT NOT NULL
);

CREATE TABLE utilizador_ativo_notificacao(
  id_utilizador INTEGER NOT NULL REFERENCES utilizador_ativo(id) ON UPDATE CASCADE,
  id_notificacao INTEGER NOT NULL REFERENCES notificacao(id) ON UPDATE CASCADE,
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

CREATE TABLE tag(
  id SERIAL PRIMARY KEY,
  nome TEXT NOT NULL
);

CREATE TABLE questao_tag(
  id_tag INTEGER NOT NULL REFERENCES tag(id) ON UPDATE CASCADE,
  id_questao INTEGER NOT NULL REFERENCES questao(id) ON UPDATE CASCADE,
  PRIMARY KEY (id_questao, id_tag)
);
