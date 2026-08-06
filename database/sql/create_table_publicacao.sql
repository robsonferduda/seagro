CREATE TABLE IF NOT EXISTS `publicacao` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `subtitulo` varchar(500) DEFAULT NULL,
  `arquivo` varchar(500) DEFAULT NULL,
  `link_externo` varchar(500) DEFAULT NULL,
  `nu_ordem` int(11) NOT NULL DEFAULT 0,
  `fl_ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
