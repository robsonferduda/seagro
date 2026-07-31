-- Arquivo visual do evento (imagem ou PDF)
ALTER TABLE `evento`
  ADD COLUMN `imagem` VARCHAR(255) NULL DEFAULT NULL AFTER `fl_nova_aba`;
