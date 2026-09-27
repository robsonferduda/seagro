CREATE TABLE IF NOT EXISTS `pagina_documento` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_pagina` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `subtitulo` varchar(255) DEFAULT NULL,
  `arquivo` varchar(500) NOT NULL,
  `dt_publicacao` date DEFAULT NULL,
  `nu_ordem` int(11) NOT NULL DEFAULT 0,
  `fl_ativo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pagina_documento_id_pagina_index` (`id_pagina`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
