-- Campos de destino do evento (página própria vs redirecionamento)
ALTER TABLE `evento`
  ADD COLUMN `tp_destino` VARCHAR(20) NOT NULL DEFAULT 'conteudo' AFTER `descricao`,
  ADD COLUMN `url_destino` VARCHAR(500) NULL DEFAULT NULL AFTER `tp_destino`,
  ADD COLUMN `fl_nova_aba` TINYINT(1) NOT NULL DEFAULT 0 AFTER `url_destino`;
