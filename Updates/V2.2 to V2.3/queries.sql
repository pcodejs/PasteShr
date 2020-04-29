ALTER TABLE `users` CHANGE `name` `name` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `users` CHANGE `email` `email` VARCHAR(191) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'public_download', '1', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'paste_title_required', '0', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'background_color', '#f7f7f7', CURRENT_TIMESTAMP, NULL), (NULL, 'background_image', NULL, CURRENT_TIMESTAMP, NULL);