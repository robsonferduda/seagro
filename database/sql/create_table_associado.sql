CREATE TABLE IF NOT EXISTS `associado` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `cpf` char(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `fl_ativo` tinyint(1) NOT NULL DEFAULT 1,
  `origem` varchar(20) NOT NULL DEFAULT 'site',
  `remember_token` varchar(100) DEFAULT NULL,
  `dt_ultimo_acesso` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `associado_cpf_unique` (`cpf`),
  KEY `associado_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `associado_senha_reset` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `associado_senha_reset_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
