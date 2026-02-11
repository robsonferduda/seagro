-- SQL para criar a tabela oportunidade no banco de dados SEAGRO
-- Execute este comando manualmente no MySQL

USE u238873253_site;

CREATE TABLE IF NOT EXISTS `oportunidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `descricao` text NOT NULL,
  `empresa` varchar(255) NOT NULL,
  `tipo` enum('Emprego','Estágio','Freelance') NOT NULL DEFAULT 'Emprego',
  `localizacao` varchar(255) NOT NULL,
  `salario` varchar(100) DEFAULT NULL,
  `dt_publicacao` date NOT NULL,
  `dt_validade` date DEFAULT NULL,
  `link_externo` varchar(500) DEFAULT NULL,
  `arquivo` varchar(255) DEFAULT NULL,
  `fl_ativo` tinyint(1) NOT NULL DEFAULT 1,
  `visualizacoes` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_tipo` (`tipo`),
  KEY `idx_ativo` (`fl_ativo`),
  KEY `idx_dt_validade` (`dt_validade`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
