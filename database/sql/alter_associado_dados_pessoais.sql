-- Dados pessoais do associado (bloco "Dados pessoais" da proposta de sócio).
-- Executar após create_tables_uf_sexo_cidade.sql e seed_cidade.sql.
-- A UF do endereço e da naturalidade vem da cidade (cidade.id_uf).
-- E-mail particular = coluna `email` já existente (também usada no acesso à Área do Associado).
-- CEP e telefones são gravados só com dígitos.

ALTER TABLE `associado`
  ADD COLUMN `dt_nascimento` date DEFAULT NULL AFTER `email`,
  ADD COLUMN `id_sexo` tinyint(3) unsigned DEFAULT NULL AFTER `dt_nascimento`,
  ADD COLUMN `id_cidade_naturalidade` int(10) unsigned DEFAULT NULL AFTER `id_sexo`,
  ADD COLUMN `cep` char(8) DEFAULT NULL AFTER `id_cidade_naturalidade`,
  ADD COLUMN `logradouro` varchar(255) DEFAULT NULL AFTER `cep`,
  ADD COLUMN `numero` varchar(20) DEFAULT NULL AFTER `logradouro`,
  ADD COLUMN `complemento` varchar(100) DEFAULT NULL AFTER `numero`,
  ADD COLUMN `bairro` varchar(100) DEFAULT NULL AFTER `complemento`,
  ADD COLUMN `id_cidade` int(10) unsigned DEFAULT NULL AFTER `bairro`,
  ADD COLUMN `email_trabalho` varchar(255) DEFAULT NULL AFTER `id_cidade`,
  ADD COLUMN `telefone_residencial` varchar(11) DEFAULT NULL AFTER `email_trabalho`,
  ADD COLUMN `telefone_celular` varchar(11) DEFAULT NULL AFTER `telefone_residencial`,
  ADD COLUMN `telefone_comercial` varchar(11) DEFAULT NULL AFTER `telefone_celular`,
  ADD CONSTRAINT `associado_id_sexo_foreign` FOREIGN KEY (`id_sexo`) REFERENCES `sexo` (`id`),
  ADD CONSTRAINT `associado_id_cidade_naturalidade_foreign` FOREIGN KEY (`id_cidade_naturalidade`) REFERENCES `cidade` (`id`),
  ADD CONSTRAINT `associado_id_cidade_foreign` FOREIGN KEY (`id_cidade`) REFERENCES `cidade` (`id`);
