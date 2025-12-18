-- marketprofilter.install.sql
-- Market PRO Filter + Полная мультиязычность (ru/en/ua) + Человекочитаемые значения
-- Cotonti Siena ≥0.9.26 | PHP ≥8.4 | MySQL ≥8.0

-- ===========================
-- Основная таблица параметров
-- ===========================
CREATE TABLE IF NOT EXISTS `cot_marketprofilter_params` (
    `param_id` INT NOT NULL AUTO_INCREMENT,
    `param_name` VARCHAR(64) NOT NULL,
    `param_title` VARCHAR(255) NOT NULL DEFAULT '' COMMENT 'Человекочитаемое название параметра',
    `param_type` ENUM('range','select','checkbox','radio') NOT NULL,
    `param_values` JSON NOT NULL COMMENT 'Технические ключи в формате JSON',
    `param_category` VARCHAR(255) NOT NULL DEFAULT '',
    `param_active` TINYINT(1) DEFAULT 1,
    PRIMARY KEY (`param_id`),
    UNIQUE KEY `param_name` (`param_name`),
    KEY `param_category` (`param_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===========================
-- Значения параметров у товаров (поддержка множественных checkbox)
-- ===========================
CREATE TABLE IF NOT EXISTS `cot_marketprofilter_params_values` (
    `value_id` INT NOT NULL AUTO_INCREMENT,
    `fieldmrkt_id` INT UNSIGNED NOT NULL,
    `param_id` INT NOT NULL,
    `param_value` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`value_id`),
    UNIQUE KEY `uniq_field_param_value` (`fieldmrkt_id`, `param_id`, `param_value`),
    KEY `fieldmrkt_id` (`fieldmrkt_id`),
    KEY `param_id` (`param_id`),
    KEY `param_value` (`param_value`(191)),
    FOREIGN KEY (`fieldmrkt_id`) REFERENCES `cot_market`(`fieldmrkt_id`) ON DELETE CASCADE,
    FOREIGN KEY (`param_id`) REFERENCES `cot_marketprofilter_params`(`param_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===========================
-- Мультиязычная таблица: названия + переводы значений
-- ===========================
CREATE TABLE IF NOT EXISTS `cot_marketprofilter_i18n` (
    `i18n_id` INT NOT NULL AUTO_INCREMENT,
    `i18n_param_id` INT NOT NULL,
    `i18n_locale` CHAR(5) NOT NULL DEFAULT 'ru',
    `i18n_title` VARCHAR(255) NOT NULL,
    `i18n_values` JSON NULL COMMENT 'JSON с локализованными значениями',
    PRIMARY KEY (`i18n_id`),
    UNIQUE KEY `uniq_param_locale` (`i18n_param_id`, `i18n_locale`),
    KEY `i18n_param_id` (`i18n_param_id`),
    KEY `i18n_locale` (`i18n_locale`),
    FOREIGN KEY (`i18n_param_id`) REFERENCES `cot_marketprofilter_params`(`param_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;