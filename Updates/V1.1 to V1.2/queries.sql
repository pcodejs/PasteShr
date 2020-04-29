INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'mail_driver', 'mail', CURRENT_TIMESTAMP, NULL), (NULL, 'mail_host', 'smtp.mailtrap.io', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'mail_port', '587', CURRENT_TIMESTAMP, NULL), (NULL, 'mail_encryption', 'tls', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'mail_username', NULL, CURRENT_TIMESTAMP, NULL), (NULL, 'mail_password', NULL, CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'mail_from_address', 'noreply@example.com', CURRENT_TIMESTAMP, NULL), (NULL, 'mail_from_name', 'PasteShr', CURRENT_TIMESTAMP, NULL);
ALTER TABLE `pastes` CHANGE `content` `content` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL;