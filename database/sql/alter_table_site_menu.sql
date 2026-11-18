-- Extende site_menu para CRUD de menus/submenus no gercont.
-- Destino: Página vinculada (id_pagina) e/ou URL livre.
-- Nota: a tabela original não tinha PRIMARY KEY nem AUTO_INCREMENT.

ALTER TABLE `site_menu`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `site_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,
  ADD COLUMN `url` varchar(500) DEFAULT NULL AFTER `apelido`,
  ADD COLUMN `id_pagina` int(11) DEFAULT NULL AFTER `url`,
  ADD COLUMN `ordem` int(11) NOT NULL DEFAULT 0 AFTER `id_pai`,
  ADD COLUMN `created_at` timestamp NULL DEFAULT NULL AFTER `ordem`,
  ADD COLUMN `updated_at` timestamp NULL DEFAULT NULL AFTER `created_at`,
  ADD KEY `site_menu_id_pai_index` (`id_pai`),
  ADD KEY `site_menu_id_pagina_index` (`id_pagina`);
