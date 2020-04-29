INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'captcha_type', '2', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'custom_captcha_style', 'default', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'custom_comments', '1', CURRENT_TIMESTAMP, NULL);

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `commenter_id` bigint(20) UNSIGNED NOT NULL,
  `commentable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `commentable_id` bigint(20) UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `child_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comments_commentable_type_commentable_id_index` (`commentable_type`,`commentable_id`),
  KEY `comments_child_id_foreign` (`child_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;