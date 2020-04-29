INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'pastes_per_page', '50', CURRENT_TIMESTAMP, NULL);
ALTER TABLE `pastes` ADD `self_destroy` TINYINT NULL DEFAULT NULL AFTER `encrypted`;
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'self_destroy_after_views', '0', CURRENT_TIMESTAMP, NULL);