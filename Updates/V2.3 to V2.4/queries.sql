ALTER TABLE `settings` CHANGE `key` `key` VARCHAR(40) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'paste_editor_line_numbers', '1', '2019-07-25 22:02:43', '2019-10-23 18:08:46');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'syntax_highlighter_line_numbers', '1', '2019-07-25 22:02:43', '2019-10-23 18:08:46');
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'trending_page', '1', CURRENT_TIMESTAMP, NULL), (NULL, 'search_page', '1', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'archive_page', '1', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'syntax_highlighter_break_word', '0', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'default_syntax', 'none', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'string_validation', '1', CURRENT_TIMESTAMP, NULL);
ALTER TABLE `users` ADD `default_paste` TEXT NULL DEFAULT NULL AFTER `gp`;