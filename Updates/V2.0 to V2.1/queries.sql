DROP TABLE IF EXISTS `social_profiles`;
CREATE TABLE IF NOT EXISTS `social_profiles` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `provider` varchar(15) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `nickname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_provider_providerId` (`provider`,`provider_id`),
  KEY `idx_userId` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

UPDATE `syntax` SET `extension` = 'html', `updated_at` = NULL WHERE `syntax`.`name` = 'Markup';
UPDATE `syntax` SET `extension` = 'abap', `updated_at` = NULL WHERE `syntax`.`name` = 'ABAP';
UPDATE `syntax` SET `extension` = 'abc', `updated_at` = NULL WHERE `syntax`.`name` = 'ABC';
UPDATE `syntax` SET `extension` = 'as', `updated_at` = NULL WHERE `syntax`.`name` = 'ActionScript';
UPDATE `syntax` SET `extension` = 'ada', `updated_at` = NULL WHERE `syntax`.`name` = 'Ada';
UPDATE `syntax` SET `extension` = 'conf', `updated_at` = NULL WHERE `syntax`.`name` = 'Apache Configuration';
UPDATE `syntax` SET `extension` = 'apex', `updated_at` = NULL WHERE `syntax`.`name` = 'Apex';
UPDATE `syntax` SET `extension` = 'asciidoc', `updated_at` = NULL WHERE `syntax`.`name` = 'AsciiDoc';
UPDATE `syntax` SET `extension` = 'asl', `updated_at` = NULL WHERE `syntax`.`name` = 'ASL';
UPDATE `syntax` SET `extension` = 'asm', `updated_at` = NULL WHERE `syntax`.`name` = '6502 Assembly';
UPDATE `syntax` SET `extension` = 'ahk', `updated_at` = NULL WHERE `syntax`.`name` = 'AutoHotKey';
UPDATE `syntax` SET `extension` = 'bat', `updated_at` = NULL WHERE `syntax`.`name` = 'Batch';
UPDATE `syntax` SET `extension` = 'bro', `updated_at` = NULL WHERE `syntax`.`name` = 'Bro';
UPDATE `syntax` SET `extension` = 'clj', `updated_at` = NULL WHERE `syntax`.`name` = 'Clojure';
UPDATE `syntax` SET `extension` = 'coffee', `updated_at` = NULL WHERE `syntax`.`name` = 'CoffeeScript';
UPDATE `syntax` SET `extension` = 'html', `updated_at` = NULL WHERE `syntax`.`name` = 'Django/Jinja2';
UPDATE `syntax` SET `extension` = 'Dockerfile', `updated_at` = NULL WHERE `syntax`.`name` = 'Docker';
UPDATE `syntax` SET `extension` = 'd', `updated_at` = NULL WHERE `syntax`.`name` = 'D';
UPDATE `syntax` SET `extension` = 'dart', `updated_at` = NULL WHERE `syntax`.`name` = 'Dart';
UPDATE `syntax` SET `extension` = 'e', `updated_at` = NULL WHERE `syntax`.`name` = 'Eiffel';
UPDATE `syntax` SET `extension` = 'ex', `updated_at` = NULL WHERE `syntax`.`name` = 'Elixir';
UPDATE `syntax` SET `extension` = 'elm', `updated_at` = NULL WHERE `syntax`.`name` = 'Elm';
UPDATE `syntax` SET `extension` = 'erl', `updated_at` = NULL WHERE `syntax`.`name` = 'Erlang';
UPDATE `syntax` SET `extension` = 'f', `updated_at` = NULL WHERE `syntax`.`name` = 'Fortran';
UPDATE `syntax` SET `extension` = 'fs', `updated_at` = NULL WHERE `syntax`.`name` = 'F#';
UPDATE `syntax` SET `extension` = 'feature', `updated_at` = NULL WHERE `syntax`.`name` = 'Gherkin';
UPDATE `syntax` SET `extension` = 'gitignore', `updated_at` = NULL WHERE `syntax`.`name` = 'Git';
UPDATE `syntax` SET `extension` = 'glsl', `updated_at` = NULL WHERE `syntax`.`name` = 'GLSL';
UPDATE `syntax` SET `extension` = 'go', `updated_at` = NULL WHERE `syntax`.`name` = 'Go';
UPDATE `syntax` SET `extension` = 'gql', `updated_at` = NULL WHERE `syntax`.`name` = 'GraphQL';
UPDATE `syntax` SET `extension` = 'groovy', `updated_at` = NULL WHERE `syntax`.`name` = 'Groovy';
UPDATE `syntax` SET `extension` = 'haml', `updated_at` = NULL WHERE `syntax`.`name` = 'Haml';
UPDATE `syntax` SET `extension` = 'hbs', `updated_at` = NULL WHERE `syntax`.`name` = 'Handlebars';
UPDATE `syntax` SET `extension` = 'hs', `updated_at` = NULL WHERE `syntax`.`name` = 'Haskell';
UPDATE `syntax` SET `extension` = 'hx', `updated_at` = NULL WHERE `syntax`.`name` = 'Haxe';
UPDATE `syntax` SET `extension` = 'ini', `updated_at` = NULL WHERE `syntax`.`name` = 'INI';
UPDATE `syntax` SET `extension` = 'io', `updated_at` = NULL WHERE `syntax`.`name` = 'IO';
UPDATE `syntax` SET `extension` = 'json', `updated_at` = NULL WHERE `syntax`.`name` = 'JSON';
UPDATE `syntax` SET `extension` = 'jl', `updated_at` = NULL WHERE `syntax`.`name` = 'Julia';
UPDATE `syntax` SET `extension` = 'kt', `updated_at` = NULL WHERE `syntax`.`name` = 'Kotlin';
UPDATE `syntax` SET `extension` = 'tex', `updated_at` = NULL WHERE `syntax`.`name` = 'LaTeX';
UPDATE `syntax` SET `extension` = 'less', `updated_at` = NULL WHERE `syntax`.`name` = 'Less';
UPDATE `syntax` SET `extension` = 'liquid', `updated_at` = NULL WHERE `syntax`.`name` = 'Liquid';
UPDATE `syntax` SET `extension` = 'lisp', `updated_at` = NULL WHERE `syntax`.`name` = 'Lisp';
UPDATE `syntax` SET `extension` = 'ls', `updated_at` = NULL WHERE `syntax`.`name` = 'LiveScript';
UPDATE `syntax` SET `extension` = 'lua', `updated_at` = NULL WHERE `syntax`.`name` = 'Lua';
UPDATE `syntax` SET `extension` = 'Makefile', `updated_at` = NULL WHERE `syntax`.`name` = 'Makefile';
UPDATE `syntax` SET `extension` = 'matlab', `updated_at` = NULL WHERE `syntax`.`name` = 'MATLAB';
UPDATE `syntax` SET `extension` = 'mel', `updated_at` = NULL WHERE `syntax`.`name` = 'MEL';
UPDATE `syntax` SET `extension` = 'nsi', `updated_at` = NULL WHERE `syntax`.`name` = 'NSIS';
UPDATE `syntax` SET `extension` = 'm', `updated_at` = NULL WHERE `syntax`.`name` = 'Objective-C';
UPDATE `syntax` SET `extension` = 'ml', `updated_at` = NULL WHERE `syntax`.`name` = 'OCaml';
UPDATE `syntax` SET `extension` = 'pas', `updated_at` = NULL WHERE `syntax`.`name` = 'Pascal';
UPDATE `syntax` SET `extension` = 'pl', `updated_at` = NULL WHERE `syntax`.`name` = 'Perl';
UPDATE `syntax` SET `extension` = 'psl', `updated_at` = NULL WHERE `syntax`.`name` = 'PowerShell';
UPDATE `syntax` SET `extension` = 'plg', `updated_at` = NULL WHERE `syntax`.`name` = 'Prolog';
UPDATE `syntax` SET `extension` = 'properties', `updated_at` = NULL WHERE `syntax`.`name` = '.properties';
UPDATE `syntax` SET `extension` = 'proto', `updated_at` = NULL WHERE `syntax`.`name` = 'Protocol Buffers';
UPDATE `syntax` SET `extension` = 'epp', `updated_at` = NULL WHERE `syntax`.`name` = 'Puppet';
UPDATE `syntax` SET `extension` = 'r', `updated_at` = NULL WHERE `syntax`.`name` = 'R';
UPDATE `syntax` SET `extension` = 'jsx', `updated_at` = NULL WHERE `syntax`.`name` = 'React JSX';
UPDATE `syntax` SET `extension` = 'tsx', `updated_at` = NULL WHERE `syntax`.`name` = 'React TSX';
UPDATE `syntax` SET `extension` = 'rb', `updated_at` = NULL WHERE `syntax`.`name` = 'Ruby';
UPDATE `syntax` SET `extension` = 'rs', `updated_at` = NULL WHERE `syntax`.`name` = 'Rust';
UPDATE `syntax` SET `extension` = 'sass', `updated_at` = NULL WHERE `syntax`.`name` = 'Sass (Sass)';
UPDATE `syntax` SET `extension` = 'scss', `updated_at` = NULL WHERE `syntax`.`name` = 'Sass (Scss)';
UPDATE `syntax` SET `extension` = 'scm', `updated_at` = NULL WHERE `syntax`.`name` = 'Scheme';
UPDATE `syntax` SET `extension` = 'soy', `updated_at` = NULL WHERE `syntax`.`name` = 'Soy (Closure Template)';
UPDATE `syntax` SET `extension` = 'styl', `updated_at` = NULL WHERE `syntax`.`name` = 'Stylus';
UPDATE `syntax` SET `extension` = 'swift', `updated_at` = NULL WHERE `syntax`.`name` = 'Swift';
UPDATE `syntax` SET `extension` = 'tcl', `updated_at` = NULL WHERE `syntax`.`name` = 'Tcl';
UPDATE `syntax` SET `extension` = 'textile', `updated_at` = NULL WHERE `syntax`.`name` = 'Textile';
UPDATE `syntax` SET `extension` = 'twig', `updated_at` = NULL WHERE `syntax`.`name` = 'Twig';
UPDATE `syntax` SET `extension` = 'ts', `updated_at` = NULL WHERE `syntax`.`name` = 'TypeScript';
UPDATE `syntax` SET `extension` = 'vm', `updated_at` = NULL WHERE `syntax`.`name` = 'Velocity';
UPDATE `syntax` SET `extension` = 'v', `updated_at` = NULL WHERE `syntax`.`name` = 'Verilog';
UPDATE `syntax` SET `extension` = 'vhdl', `updated_at` = NULL WHERE `syntax`.`name` = 'VHDL';
UPDATE `syntax` SET `extension` = 'vbs', `updated_at` = NULL WHERE `syntax`.`name` = 'Visual Basic';
UPDATE `syntax` SET `extension` = 'xq', `updated_at` = NULL WHERE `syntax`.`name` = 'XQuery';
UPDATE `syntax` SET `extension` = 'yaml', `updated_at` = NULL WHERE `syntax`.`name` = 'YAML';
UPDATE `syntax` SET `extension` = 'diff', `updated_at` = NULL WHERE `syntax`.`name` = 'Diff';
UPDATE `syntax` SET `extension` = 'erb', `updated_at` = NULL WHERE `syntax`.`name` = 'ERB';
UPDATE `syntax` SET `extension` = 'txt', `updated_at` = NULL WHERE `syntax`.`name` = 'Plaintext';
INSERT INTO `syntax` (`id`, `name`, `slug`, `extension`, `active`, `popular`, `created_at`, `updated_at`) VALUES (NULL, 'HTML', 'markup', 'html', '1', '0', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'paste_editor', 'ace', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'syntax_highlighter', 'ace', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'ace_editor_skin', 'monokai', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'social_login_facebook', '0', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'social_login_twitter', '0', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'social_login_google', '0', CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'FACEBOOK_CLIENT_ID', NULL, CURRENT_TIMESTAMP, NULL), (NULL, 'FACEBOOK_CLIENT_SECRET', NULL, CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'TWITTER_CLIENT_ID', NULL, CURRENT_TIMESTAMP, NULL), (NULL, 'TWITTER_CLIENT_SECRET', NULL, CURRENT_TIMESTAMP, NULL);
INSERT INTO `settings` (`id`, `key`, `value`, `created_at`, `updated_at`) VALUES (NULL, 'GOOGLE_CLIENT_ID', NULL, CURRENT_TIMESTAMP, NULL), (NULL, 'GOOGLE_CLIENT_SECRET', NULL, CURRENT_TIMESTAMP, NULL);