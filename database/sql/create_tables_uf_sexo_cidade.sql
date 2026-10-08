-- Tabelas de domínio usadas no cadastro do associado.
-- Executar antes de seed_cidade.sql e alter_associado_dados_pessoais.sql.
-- Os ids de uf e cidade são os códigos oficiais do IBGE (o ViaCEP devolve o mesmo código no campo "ibge").

CREATE TABLE IF NOT EXISTS `uf` (
  `id` tinyint(3) unsigned NOT NULL,
  `sigla` char(2) NOT NULL,
  `nome` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uf_sigla_unique` (`sigla`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `cidade` (
  `id` int(10) unsigned NOT NULL,
  `id_uf` tinyint(3) unsigned NOT NULL,
  `nome` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cidade_id_uf_nome_index` (`id_uf`, `nome`),
  CONSTRAINT `cidade_id_uf_foreign` FOREIGN KEY (`id_uf`) REFERENCES `uf` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `sexo` (
  `id` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `sigla` char(1) NOT NULL,
  `nome` varchar(30) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sexo_sigla_unique` (`sigla`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO `uf` (`id`, `sigla`, `nome`) VALUES
(11, 'RO', 'Rondônia'),
(12, 'AC', 'Acre'),
(13, 'AM', 'Amazonas'),
(14, 'RR', 'Roraima'),
(15, 'PA', 'Pará'),
(16, 'AP', 'Amapá'),
(17, 'TO', 'Tocantins'),
(21, 'MA', 'Maranhão'),
(22, 'PI', 'Piauí'),
(23, 'CE', 'Ceará'),
(24, 'RN', 'Rio Grande do Norte'),
(25, 'PB', 'Paraíba'),
(26, 'PE', 'Pernambuco'),
(27, 'AL', 'Alagoas'),
(28, 'SE', 'Sergipe'),
(29, 'BA', 'Bahia'),
(31, 'MG', 'Minas Gerais'),
(32, 'ES', 'Espírito Santo'),
(33, 'RJ', 'Rio de Janeiro'),
(35, 'SP', 'São Paulo'),
(41, 'PR', 'Paraná'),
(42, 'SC', 'Santa Catarina'),
(43, 'RS', 'Rio Grande do Sul'),
(50, 'MS', 'Mato Grosso do Sul'),
(51, 'MT', 'Mato Grosso'),
(52, 'GO', 'Goiás'),
(53, 'DF', 'Distrito Federal');

INSERT IGNORE INTO `sexo` (`id`, `sigla`, `nome`) VALUES
(1, 'M', 'Masculino'),
(2, 'F', 'Feminino');
