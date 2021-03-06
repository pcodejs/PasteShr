INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'feature_share', '1', CURRENT_TIMESTAMP, NULL), (NULL, 'feature_copy', '1', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'feature_raw', '1', '2018-12-31 17:55:44', NULL), (NULL, 'feature_download', '1', '2018-12-31 17:55:44', NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'feature_clone', '1', '2018-12-31 17:55:44', NULL), (NULL, 'feature_embed', '1', '2018-12-31 17:55:44', NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'feature_report', '1', '2018-12-31 17:55:44', NULL), (NULL, 'feature_print', '1', '2018-12-31 17:55:44', NULL);
ALTER TABLE `pastes` ADD `password` VARCHAR(100) NULL DEFAULT NULL AFTER `views`;
ALTER TABLE `pastes` ADD `encrypted` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0' AFTER `password`;
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'my_recent_pastes_limit', '3', CURRENT_TIMESTAMP, NULL);
ALTER TABLE `pastes` ADD `ip_address` VARCHAR(100) NULL DEFAULT NULL AFTER `user_id`;
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'daily_paste_limit_unauth', '10', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'daily_paste_limit_auth', '50', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'site_logo', NULL, CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'site_favicon', '/favicon.png', CURRENT_TIMESTAMP, NULL), (NULL, 'site_image', '/img/image.png', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'analytics_code', NULL, CURRENT_TIMESTAMP, NULL);
ALTER TABLE `languages` CHANGE `name` `name` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;