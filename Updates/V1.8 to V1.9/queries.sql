ALTER TABLE `pastes` CHANGE `content` `content` LONGBLOB NULL DEFAULT NULL;
UPDATE `syntax` SET `slug` = 'none' WHERE `syntax`.`name` = 'Plaintext';
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'paste_storage', 'database', CURRENT_TIMESTAMP, NULL);
ALTER TABLE `pastes` ADD `storage` TINYINT NOT NULL DEFAULT '1' COMMENT '1 - Database / 2- File' AFTER `self_destroy`;