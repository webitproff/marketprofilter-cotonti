-- marketprofilter.install.sql
-- Market PRO Filter + Полная мультиязычность (ru/en/ua)
-- Cotonti CMF v.1+ | PHP ≥8.4 | MySQL ≥8.0
-- Date=June 21Th, 2026
-- Plugin Market PRO Filter (Source code):  https://github.com/webitproff/marketprofilter-cotonti
-- version 3.3.36


CREATE TABLE IF NOT EXISTS `cot_marketprofilter_params` (
    `param_id` INT NOT NULL AUTO_INCREMENT,
    `param_name` VARCHAR(64) NOT NULL,
    `param_title` VARCHAR(255) NOT NULL DEFAULT '',
    `param_type` ENUM('range','select','checkbox','radio') NOT NULL,
    `param_values` JSON NOT NULL,
    `param_category` VARCHAR(255) NOT NULL DEFAULT '',
    `param_active` TINYINT(1) DEFAULT 1,
    `param_superadmin` TINYINT(1) NOT NULL DEFAULT 0,
    `param_helpinfo` TEXT NULL,  
	`param_hidelistitem` TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (`param_id`),
    UNIQUE KEY `param_name` (`param_name`),
    KEY `param_category` (`param_category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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

CREATE TABLE IF NOT EXISTS `cot_marketprofilter_i18n` (
    `i18n_id` INT NOT NULL AUTO_INCREMENT,
    `i18n_param_id` INT NOT NULL,
    `i18n_locale` CHAR(5) NOT NULL DEFAULT 'ru',
    `i18n_title` VARCHAR(255) NOT NULL,
    `i18n_values` JSON NULL,
    `i18n_helpinfo` TEXT NULL,   
    PRIMARY KEY (`i18n_id`),
    UNIQUE KEY `uniq_param_locale` (`i18n_param_id`, `i18n_locale`),
    KEY `i18n_param_id` (`i18n_param_id`),
    KEY `i18n_locale` (`i18n_locale`),
    FOREIGN KEY (`i18n_param_id`) REFERENCES `cot_marketprofilter_params`(`param_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- INSERT-ы остаются без изменений (параметры param_helpinfo и i18n_helpinfo не указаны, получат NULL)

-- Параметры
INSERT INTO `cot_marketprofilter_params` (`param_id`, `param_name`, `param_title`, `param_type`, `param_values`, `param_category`, `param_active`) VALUES
(9, '001_samokat_max_speed', 'Максимальна швидкість, км/год', 'select', '["speed_lte_10", "speed_10_25", "speed_25_35", "speed_35_50", "speed_50_60", "speed_60_70", "speed_70_80", "speed_80_90", "speed_90_100", "speed_gt_100"]', 'electric-scooters', 1),
(10, '001_samokat_nom_power', 'Номінальна потужність, Вт', 'select', '["power_lte_350", "power_350_500", "power_500_750", "power_750_1000", "power_1000_1250", "power_1250_1700", "power_1700_2000", "power_2000_3000", "power_gt_3000"]', 'electric-scooters', 1),
(11, '001_samokat_battery_voltage', 'Вольтаж акумулятору, В', 'checkbox', '["12", "24", "36", "48", "52", "60", "72", "76", "84", "96", "100"]', 'electric-scooters', 1),
(12, '001_samokat_battery_capacity', 'Ємність акумулятора, Ah', 'select', '["ah_lte_10", "ah_11", "ah_12", "ah_13", "ah_14", "ah_15", "ah_16", "ah_17", "ah_18", "ah_19", "ah_20", "ah_21", "ah_22", "ah_23", "ah_24", "ah_25", "ah_25_28", "ah_28_31", "ah_31_34", "ah_34_37", "ah_37_40", "ah_40_44", "ah_44_48", "ah_48_52", "ah_52_56", "ah_56_60", "ah_60_65", "ah_65_70", "ah_70_75", "ah_75_80", "ah_80_88", "ah_88_96", "ah_96_100", "ah_gt_100"]', 'electric-scooters', 1),
(13, '001_samokat_features', 'Особливості модифікації', 'checkbox', '["digital_display", "speedometer", "mobile_app", "nfc_key", "physical_ignition_key", "alarm", "front_headlight", "brake_light", "turn_signals", "frame_wheel_light", "foldable", "eccentric_clamp", "adjustable_handlebar", "wide_deck", "seat", "suspension", "dual_brake", "regenerative_braking", "cruise_control", "ip_waterproof", "luggage_rack", "basket", "lockable_case", "removable_battery"]', 'electric-scooters', 1),
(14, '001_samokat_wheel_diameter', 'Діаметр коліс, дюйми', 'select', '["6", "7", "8", "9", "10", "11", "12", "14", "16", "18", "20"]', 'electric-scooters', 1),
(15, '001_samokat_suspension_type', 'Тип амортизації', 'radio', '["no_suspension", "front_suspension", "rear_suspension", "dual_suspension", "dual_reinforced_suspension"]', 'electric-scooters', 1);

-- Переводы
INSERT INTO `cot_marketprofilter_i18n` (`i18n_param_id`, `i18n_locale`, `i18n_title`, `i18n_values`) VALUES
(9, 'ua', 'Максимальна швидкість, км/год', '{"speed_10_25": "10.1 - 25", "speed_25_35": "25.1 - 35", "speed_35_50": "35.1 - 50", "speed_50_60": "50.1 - 60", "speed_60_70": "60.1 - 70", "speed_70_80": "70.1 - 80", "speed_80_90": "80.1 - 90", "speed_90_100": "90.1 - 100", "speed_gt_100": "100.1 - і більше", "speed_lte_10": "10 і менше"}'),
(9, 'en', 'Max Speed, km/h', '{"speed_10_25": "10.1 - 25", "speed_25_35": "25.1 - 35", "speed_35_50": "35.1 - 50", "speed_50_60": "50.1 - 60", "speed_60_70": "60.1 - 70", "speed_70_80": "70.1 - 80", "speed_80_90": "80.1 - 90", "speed_90_100": "90.1 - 100", "speed_gt_100": "100.1 and over", "speed_lte_10": "10 and under"}'),
(9, 'ru', 'Максимальная скорость, км/ч', '{"speed_10_25": "10.1 - 25", "speed_25_35": "25.1 - 35", "speed_35_50": "35.1 - 50", "speed_50_60": "50.1 - 60", "speed_60_70": "60.1 - 70", "speed_70_80": "70.1 - 80", "speed_80_90": "80.1 - 90", "speed_90_100": "90.1 - 100", "speed_gt_100": "100.1 и более", "speed_lte_10": "10 и менее"}'),
(10, 'ua', 'Номінальна потужність, Вт', '{"power_350_500": "350.1 - 500", "power_500_750": "500.1 - 750", "power_gt_3000": "3000.1 - і більше", "power_lte_350": "до 350", "power_750_1000": "750.1 - 1000", "power_1000_1250": "1000.1 - 1250", "power_1250_1700": "1250.1 - 1700", "power_1700_2000": "1700.1 - 2000", "power_2000_3000": "2000.1 - 3000"}'),
(10, 'en', 'Nominal Power, W', '{"power_350_500": "350.1 - 500", "power_500_750": "500.1 - 750", "power_gt_3000": "3000.1 and over", "power_lte_350": "up to 350", "power_750_1000": "750.1 - 1000", "power_1000_1250": "1000.1 - 1250", "power_1250_1700": "1250.1 - 1700", "power_1700_2000": "1700.1 - 2000", "power_2000_3000": "2000.1 - 3000"}'),
(10, 'ru', 'Номинальная мощность, Вт', '{"power_350_500": "350.1 - 500", "power_500_750": "500.1 - 750", "power_gt_3000": "3000.1 и более", "power_lte_350": "до 350", "power_750_1000": "750.1 - 1000", "power_1000_1250": "1000.1 - 1250", "power_1250_1700": "1250.1 - 1700", "power_1700_2000": "1700.1 - 2000", "power_2000_3000": "2000.1 - 3000"}'),
(11, 'ua', 'Вольтаж акумулятора, В', '{"12": "12", "24": "24", "36": "36", "48": "48", "52": "52", "60": "60", "72": "72", "76": "76", "84": "84", "96": "96", "100": "100"}'),
(11, 'en', 'Battery Voltage, V', '{"12": "12", "24": "24", "36": "36", "48": "48", "52": "52", "60": "60", "72": "72", "76": "76", "84": "84", "96": "96", "100": "100"}'),
(11, 'ru', 'Вольтаж аккумулятора, В', '{"12": "12", "24": "24", "36": "36", "48": "48", "52": "52", "60": "60", "72": "72", "76": "76", "84": "84", "96": "96", "100": "100"}'),
(12, 'ua', 'Ємність акумулятора, Ah', '{"ah_11": "11", "ah_12": "12", "ah_13": "13", "ah_14": "14", "ah_15": "15", "ah_16": "16", "ah_17": "17", "ah_18": "18", "ah_19": "19", "ah_20": "20", "ah_21": "21", "ah_22": "22", "ah_23": "23", "ah_24": "24", "ah_25": "25", "ah_25_28": "25.1 – 28", "ah_28_31": "28.1 – 31", "ah_31_34": "31.1 – 34", "ah_34_37": "34.1 – 37", "ah_37_40": "37.1 – 40", "ah_40_44": "40.1 – 44", "ah_44_48": "44.1 – 48", "ah_48_52": "48.1 – 52", "ah_52_56": "52.1 – 56", "ah_56_60": "56.1 – 60", "ah_60_65": "60.1 – 65", "ah_65_70": "65.1 – 70", "ah_70_75": "70.1 – 75", "ah_75_80": "75.1 – 80", "ah_80_88": "80.1 – 88", "ah_88_96": "88.1 – 96", "ah_96_100": "96.1 – 100", "ah_gt_100": "100.1 і більше", "ah_lte_10": "до 10"}'),
(12, 'en', 'Battery Capacity, Ah', '{"ah_11": "11", "ah_12": "12", "ah_13": "13", "ah_14": "14", "ah_15": "15", "ah_16": "16", "ah_17": "17", "ah_18": "18", "ah_19": "19", "ah_20": "20", "ah_21": "21", "ah_22": "22", "ah_23": "23", "ah_24": "24", "ah_25": "25", "ah_25_28": "25.1 – 28", "ah_28_31": "28.1 – 31", "ah_31_34": "31.1 – 34", "ah_34_37": "34.1 – 37", "ah_37_40": "37.1 – 40", "ah_40_44": "40.1 – 44", "ah_44_48": "44.1 – 48", "ah_48_52": "48.1 – 52", "ah_52_56": "52.1 – 56", "ah_56_60": "56.1 – 60", "ah_60_65": "60.1 – 65", "ah_65_70": "65.1 – 70", "ah_70_75": "70.1 – 75", "ah_75_80": "75.1 – 80", "ah_80_88": "80.1 – 88", "ah_88_96": "88.1 – 96", "ah_96_100": "96.1 – 100", "ah_gt_100": "100.1 and over", "ah_lte_10": "up to 10"}'),
(12, 'ru', 'Ёмкость аккумулятора, Ah', '{"ah_11": "11", "ah_12": "12", "ah_13": "13", "ah_14": "14", "ah_15": "15", "ah_16": "16", "ah_17": "17", "ah_18": "18", "ah_19": "19", "ah_20": "20", "ah_21": "21", "ah_22": "22", "ah_23": "23", "ah_24": "24", "ah_25": "25", "ah_25_28": "25.1 – 28", "ah_28_31": "28.1 – 31", "ah_31_34": "31.1 – 34", "ah_34_37": "34.1 – 37", "ah_37_40": "37.1 – 40", "ah_40_44": "40.1 – 44", "ah_44_48": "44.1 – 48", "ah_48_52": "48.1 – 52", "ah_52_56": "52.1 – 56", "ah_56_60": "56.1 – 60", "ah_60_65": "60.1 – 65", "ah_65_70": "65.1 – 70", "ah_70_75": "70.1 – 75", "ah_75_80": "75.1 – 80", "ah_80_88": "80.1 – 88", "ah_88_96": "88.1 – 96", "ah_96_100": "96.1 – 100", "ah_gt_100": "100.1 и более", "ah_lte_10": "до 10"}'),
(13, 'ua', 'Особливості модифікації', '{"seat": "Сидіння", "alarm": "Сигналізація", "basket": "Кошик для багажу", "nfc_key": "Ключ NFC (безконтактна карта/телефон)", "foldable": "Складний", "wide_deck": "Широка платформа", "dual_brake": "Подвійна гальмівна система", "mobile_app": "Мобільний додаток", "suspension": "Підвіска", "brake_light": "Стоп-сигнал", "speedometer": "Спідометр", "luggage_rack": "Багажник", "turn_signals": "Поворотники", "ip_waterproof": "Вологозахист (IP)", "lockable_case": "Кофр (бокс із замком)", "cruise_control": "Круїз-контроль", "digital_display": "Цифровий дисплей", "eccentric_clamp": "Ексцентриковий затискач/механізм", "front_headlight": "Передня фара", "frame_wheel_light": "Підсвічування рами та/або коліс", "removable_battery": "Знімний акумулятор", "adjustable_handlebar": "Регульована висота руля", "regenerative_braking": "Рекуперація", "physical_ignition_key": "Фізичний ключ із замком запалювання"}'),
(13, 'en', 'Modification Features', '{"seat": "Seat", "alarm": "Alarm", "basket": "Basket", "nfc_key": "NFC Key (Contactless Card/Phone)", "foldable": "Foldable", "wide_deck": "Wide Deck", "dual_brake": "Dual Brake System", "mobile_app": "Mobile App", "suspension": "Suspension", "brake_light": "Brake Light", "speedometer": "Speedometer", "luggage_rack": "Luggage Rack", "turn_signals": "Turn Signals", "ip_waterproof": "Waterproof (IP Rating)", "lockable_case": "Lockable Case", "cruise_control": "Cruise Control", "digital_display": "Digital Display", "eccentric_clamp": "Eccentric Clamp/Mechanism", "front_headlight": "Front Headlight", "frame_wheel_light": "Frame / Wheel Lighting", "removable_battery": "Removable Battery", "adjustable_handlebar": "Adjustable Handlebar Height", "regenerative_braking": "Regenerative Braking", "physical_ignition_key": "Physical Ignition Key"}'),
(13, 'ru', 'Особенности модификации', '{"seat": "Сиденье", "alarm": "Сигнализация", "basket": "Корзина для багажа", "nfc_key": "Ключ NFC (бесконтактная карта/телефон)", "foldable": "Складной", "wide_deck": "Широкая платформа", "dual_brake": "Двойная тормозная система", "mobile_app": "Мобильное приложение", "suspension": "Подвеска", "brake_light": "Стоп-сигнал", "speedometer": "Спидометр", "luggage_rack": "Багажник", "turn_signals": "Поворотники", "ip_waterproof": "Влагозащита (IP)", "lockable_case": "Кофр (бокс с замком)", "cruise_control": "Круиз-контроль", "digital_display": "Цифровой дисплей", "eccentric_clamp": "Эксцентриковый зажим/механизм", "front_headlight": "Передняя фара", "frame_wheel_light": "Подсветка рамы и/или колёс", "removable_battery": "Съёмный аккумулятор", "adjustable_handlebar": "Регулируемая высота руля", "regenerative_braking": "Рекуперация", "physical_ignition_key": "Физический ключ с замком зажигания"}'),
(14, 'ua', 'Діаметр коліс, дюйми', '{"6": "6\\"", "7": "7\\"", "8": "8\\"", "9": "9\\"", "10": "10\\"", "11": "11\\"", "12": "12\\"", "14": "14\\"", "16": "16\\"", "18": "18\\"", "20": "20\\""}'),
(14, 'en', 'Wheel Diameter, inches', '{"6": "6\\"", "7": "7\\"", "8": "8\\"", "9": "9\\"", "10": "10\\"", "11": "11\\"", "12": "12\\"", "14": "14\\"", "16": "16\\"", "18": "18\\"", "20": "20\\""}'),
(14, 'ru', 'Диаметр колёс, дюймы', '{"6": "6\\"", "7": "7\\"", "8": "8\\"", "9": "9\\"", "10": "10\\"", "11": "11\\"", "12": "12\\"", "14": "14\\"", "16": "16\\"", "18": "18\\"", "20": "20\\""}'),
(15, 'ua', 'Тип амортизації', '{"no_suspension": "Без амортизації", "dual_suspension": "Подвійна амортизація", "rear_suspension": "Задня амортизація", "front_suspension": "Передня амортизація", "dual_reinforced_suspension": "Подвійна підвіска посилена"}'),
(15, 'en', 'Suspension Type', '{"no_suspension": "No Suspension", "dual_suspension": "Dual Suspension", "rear_suspension": "Rear Suspension", "front_suspension": "Front Suspension", "dual_reinforced_suspension": "Dual Reinforced Suspension"}'),
(15, 'ru', 'Тип амортизации', '{"no_suspension": "Без амортизации", "dual_suspension": "Двойная амортизация", "rear_suspension": "Задняя амортизация", "front_suspension": "Передняя амортизация", "dual_reinforced_suspension": "Двойная подвеска усиленная"}');

-- Пример параметра типа range (цена, грн)
INSERT INTO `cot_marketprofilter_params` (`param_id`, `param_name`, `param_title`, `param_type`, `param_values`, `param_category`, `param_active`) VALUES
(32, '000_05_price', 'Ціна, грн', 'range', '{"min":100,"max":120000}', '', 1);

-- Параметры цвета (radio и checkbox)
INSERT INTO `cot_marketprofilter_params` (`param_id`, `param_name`, `param_title`, `param_type`, `param_values`, `param_category`, `param_active`) VALUES
(33, 'color_radio', 'Колір (один)', 'radio', '["white","black","gray","red","blue","green","lime","yellow","orange","pink","purple","brown","cyan","teal","indigo","maroon","navy","olive"]', '', 1),
(34, 'color_checkbox', 'Кольори (декілька)', 'checkbox', '["white","black","gray","red","blue","green","lime","yellow","orange","pink","purple","brown","cyan","teal","indigo","maroon","navy","olive"]', '', 1);

-- Переводы для color_radio
INSERT INTO `cot_marketprofilter_i18n` (`i18n_param_id`, `i18n_locale`, `i18n_title`, `i18n_values`) VALUES
(33, 'ua', 'Колір (один)', '{"white":"Білий","black":"Чорний","gray":"Сірий","red":"Червоний","blue":"Синій","green":"Зелений","lime":"Лайм (салатовий)","yellow":"Жовтий","orange":"Помаранчевий","pink":"Рожевий","purple":"Фіолетовий","brown":"Коричневий","cyan":"Блакитний (ціан)","teal":"Бірюзовий","indigo":"Індиго","maroon":"Темно-бордовий","navy":"Темно-синій","olive":"Оливковий"}'),
(33, 'en', 'Color (single)', '{"white":"White","black":"Black","gray":"Gray","red":"Red","blue":"Blue","green":"Green","lime":"Lime","yellow":"Yellow","orange":"Orange","pink":"Pink","purple":"Purple","brown":"Brown","cyan":"Cyan","teal":"Teal","indigo":"Indigo","maroon":"Maroon","navy":"Navy","olive":"Olive"}'),
(33, 'ru', 'Цвет (один)', '{"white":"Белый","black":"Чёрный","gray":"Серый","red":"Красный","blue":"Синий","green":"Зелёный","lime":"Лайм (салатовый)","yellow":"Жёлтый","orange":"Оранжевый","pink":"Розовый","purple":"Фиолетовый","brown":"Коричневый","cyan":"Голубой (циан)","teal":"Бирюзовый","indigo":"Индиго","maroon":"Тёмно-бордовый","navy":"Тёмно-синий","olive":"Оливковый"}');

-- Переводы для color_checkbox
INSERT INTO `cot_marketprofilter_i18n` (`i18n_param_id`, `i18n_locale`, `i18n_title`, `i18n_values`) VALUES
(34, 'ua', 'Кольори (декілька)', '{"white":"Білий","black":"Чорний","gray":"Сірий","red":"Червоний","blue":"Синій","green":"Зелений","lime":"Лайм (салатовий)","yellow":"Жовтий","orange":"Помаранчевий","pink":"Рожевий","purple":"Фіолетовий","brown":"Коричневий","cyan":"Блакитний (ціан)","teal":"Бірюзовий","indigo":"Індиго","maroon":"Темно-бордовий","navy":"Темно-синій","olive":"Оливковий"}'),
(34, 'en', 'Colors (multi)', '{"white":"White","black":"Black","gray":"Gray","red":"Red","blue":"Blue","green":"Green","lime":"Lime","yellow":"Yellow","orange":"Orange","pink":"Pink","purple":"Purple","brown":"Brown","cyan":"Cyan","teal":"Teal","indigo":"Indigo","maroon":"Maroon","navy":"Navy","olive":"Olive"}'),
(34, 'ru', 'Цвета (несколько)', '{"white":"Белый","black":"Чёрный","gray":"Серый","red":"Красный","blue":"Синий","green":"Зелёный","lime":"Лайм (салатовый)","yellow":"Жёлтый","orange":"Оранжевый","pink":"Розовый","purple":"Фиолетовый","brown":"Коричневый","cyan":"Голубой (циан)","teal":"Бирюзовый","indigo":"Индиго","maroon":"Тёмно-бордовый","navy":"Тёмно-синий","olive":"Оливковый"}');

