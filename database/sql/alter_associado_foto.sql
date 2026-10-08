-- Foto do associado (campo "Foto" da proposta de sócio).
-- O arquivo fica em storage/app/associados/fotos (fora da pasta pública) e é servido só para usuários autenticados.

ALTER TABLE `associado`
  ADD COLUMN `foto` varchar(100) DEFAULT NULL AFTER `telefone_comercial`;
