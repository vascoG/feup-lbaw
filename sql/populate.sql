INSERT INTO palavra_passe(id,palavra_passe,palavra_passe_salt)
VALUES (generate_series(1,1010),md5(random()::text),md5(random()::text));
INSERT INTO utilizador(id,nome_utilizador,nome,id_palavra_passe,moderador,administrador)
VALUES (generate_series(1,1000),md5(random()::text),md5(random()::text),generate_series(1,1000),FALSE,FALSE);
INSERT INTO utilizador(id,nome_utilizador,nome,id_palavra_passe,moderador,administrador)
VALUES
(1001,'vasco8','Vasco Gomes',1001,FALSE,TRUE),
(1002,'mari75','Maria Santos',1002,TRUE,FALSE),
(1003,'marci_24','Marcia Carvalho',1003,TRUE,FALSE),
(1004,'m_monteiro','Mariana Monteiro',1004,FALSE,TRUE),
(1005,'francisco1','Francisco Oliveira',1005,FALSE,TRUE),
(1006,'j_rodrigo','João Rodrigo',1006,FALSE,TRUE),
(1007,'leonor2001','Leonor Castro',1007,TRUE,FALSE),
(1008,'mariapinto','Maria Pinto',1008,TRUE,FALSE),
(1009,'martim22','Martim Castro',1009,TRUE,FALSE),
(1010,'carla_mirra','Carla Mirra',1010,TRUE,FALSE);
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