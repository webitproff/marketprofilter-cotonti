-- marketprofilter.install.mysql8.sql
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

-- ===========================
-- ДАННЫЕ (актуальные на основе дампа от 13 декабря 2025)
-- ===========================

-- 1. Доступность (param_id = 6)
INSERT INTO `cot_marketprofilter_params`
(`param_id`, `param_name`, `param_title`, `param_type`, `param_values`, `param_category`, `param_active`) VALUES
(6, '001_paid_item', 'Доступность', 'checkbox', JSON_ARRAY('free','paid_download','paid_request'), '', 1);

INSERT INTO `cot_marketprofilter_i18n`
(`i18n_param_id`, `i18n_locale`, `i18n_title`, `i18n_values`) VALUES
(6, 'ru', 'Доступность', JSON_OBJECT('free','Бесплатно','paid_download','Заплатить и скачать','paid_request','Платно и по заказу')),
(6, 'en', 'Availability', JSON_OBJECT('free','Free','paid_download','Pay & Download','paid_request','Paid on Request')),
(6, 'ua', 'Доступність', JSON_OBJECT('free','Безкоштовно','paid_download','Оплатити та завантажити','paid_request','Платно за запитом'));

-- 2. Версия OpenCart (param_id = 5)
INSERT INTO `cot_marketprofilter_params`
(`param_id`, `param_name`, `param_title`, `param_type`, `param_values`, `param_category`, `param_active`) VALUES
(5, '002_oc-mods-version', 'Версия OpenCart', 'checkbox', JSON_ARRAY('1.5.x.x','2.0.x.x','2.1.x.x','2.2.x.x','2.3.x.x','3.0.x.x','4.0.x.x','4.1.x.x','4.x.x.x'), 'oc-mods', 1);

INSERT INTO `cot_marketprofilter_i18n`
(`i18n_param_id`, `i18n_locale`, `i18n_title`, `i18n_values`) VALUES
(5, 'ru', 'Версия OpenCart', NULL),
(5, 'en', 'OpenCart Version', NULL),
(5, 'ua', 'Версія OpenCart', NULL);

-- 3. Назначение или категория (param_id = 7)
INSERT INTO `cot_marketprofilter_params`
(`param_id`, `param_name`, `param_title`, `param_type`, `param_values`, `param_category`, `param_active`) VALUES
(7, '002_oc-mods-purpose', 'Назначение или категория', 'select', JSON_ARRAY('admin','ar_vr','security','blog','bonuses','booking','ai','ready_sites','delivery','games','import_export','1c','totals','cache','cart','feeds','livestream','marketing','design','pwa','i18n','navigation','feedback','omnichannel','notifications','reviews','reports','parsers','payments','search','subscriptions','events','prices','geo','media','editor','ads','bundles','galleries','social','compare','telegram','marketplaces','filters','attributes','utils','seo','vqmod','other'), 'oc-mods', 1);

-- Переводы для param_id = 7 (разбиты по языкам для надёжной установки)
INSERT INTO `cot_marketprofilter_i18n` (`i18n_param_id`, `i18n_locale`, `i18n_title`, `i18n_values`) VALUES
(7, 'ru', 'Назначение или категория', JSON_OBJECT(
    '1c','Интеграция с 1С, ERP и складским учётом',
    'ai','Генеративный AI, чатботы и персонализация',
    'ads','Реклама и продвижение',
    'geo','Работа с картами и Geo IP',
    'pwa','Мобильные приложения и PWA',
    'seo','SEO и оптимизация',
    'blog','Блоги, новости, статьи',
    'cart','Корзина и оформление заказа',
    'i18n','Многоязычность и перевод (i18n)',
    'admin','Администрирование и управление',
    'ar_vr','AR/VR и 3D-визуализация товаров',
    'cache','Кэширование, сжатие и ускорение сайта',
    'feeds','Ленты товаров',
    'games','Игры и кланы',
    'media','Работа с медиа (фото, видео, файлы)',
    'other','Прочее',
    'utils','Утилиты и инструменты',
    'vqmod','VQMod, скрипты после установки и модификаторы',
    'design','Меню, дизайн и внешний вид',
    'editor','Редакторы и работа с текстом',
    'events','Публикации и мероприятия',
    'prices','Работа с акциями, скидками и ценами',
    'search','Поиск',
    'social','Социальная коммерция и интеграции с соцсетями',
    'totals','Итоговые суммы и учёт в заказе',
    'bonuses','Бонусы, купоны, программы лояльности',
    'booking','Бронирование и календари',
    'bundles','Серии, комплекты и бандлы',
    'compare','Сравнение товаров, избранное и закладки',
    'filters','Фильтры',
    'parsers','Парсеры и сбор данных',
    'reports','Отчёты и аналитика',
    'reviews','Отзывы и UGC',
    'delivery','Доставки и службы доставки',
    'feedback','Обратная связь, формы и онлайн-звонки',
    'payments','Платёжные системы и шлюзы',
    'security','Безопасность и аутентификация',
    'telegram','Telegram-интеграции и мини-приложения',
    'galleries','Слайдшоу, баннеры, галереи',
    'marketing','Маркетинг и реклама',
    'attributes','Характеристики, Атрибуты и Опции товаров',
    'livestream','Livestream и видео-шоппинг',
    'navigation','Навигация и структура сайта',
    'omnichannel','Омниканальность и composable/headless commerce',
    'ready_sites','Готовые сайты и темы',
    'marketplaces','Торговые площадки (маркетплейсы)',
    'import_export','Импорт, экспорт и обмен данными',
    'notifications','Оповещения, рассылки, email и SMS',
    'subscriptions','Подписки и регулярные платежи'
));

INSERT INTO `cot_marketprofilter_i18n` (`i18n_param_id`, `i18n_locale`, `i18n_title`, `i18n_values`) VALUES
(7, 'en', 'Purpose or Category', JSON_OBJECT(
    '1c','1C, ERP & Warehouse Integration',
    'ai','Generative AI, Chatbots & Personalization',
    'ads','Advertising & Promotion',
    'geo','Maps & Geo IP',
    'pwa','Mobile Apps & PWA',
    'seo','SEO & Optimization',
    'blog','Blogs, News, Articles',
    'cart','Cart & Checkout',
    'i18n','Multilingual & Translation (i18n)',
    'admin','Administration & Management',
    'ar_vr','AR/VR & 3D Product Visualization',
    'cache','Caching, Compression & Speed Optimization',
    'feeds','Product Feeds',
    'games','Games & Clans',
    'media','Working with Media (Photos, Videos, Files)',
    'other','Other',
    'utils','Utilities & Tools',
    'vqmod','VQMod, Post-Install Scripts & Modifiers',
    'design','Menu, Design & Appearance',
    'editor','Editors & Text Processing',
    'events','Publications & Events',
    'prices','Promotions, Discounts & Pricing',
    'search','Search',
    'social','Social Commerce & Integrations',
    'totals','Order Totals & Accounting',
    'bonuses','Bonuses, Coupons, Loyalty Programs',
    'booking','Booking & Calendars',
    'bundles','Bundles & Kits',
    'compare','Compare, Wishlist & Bookmarks',
    'filters','Filters',
    'parsers','Parsers & Data Scraping',
    'reports','Reports & Analytics',
    'reviews','Reviews & UGC',
    'delivery','Shipping & Delivery Services',
    'feedback','Feedback, Forms & Online Calls',
    'payments','Payment Gateways',
    'security','Security & Authentication',
    'telegram','Telegram Integrations & Mini-Apps',
    'galleries','Sliders, Banners, Galleries',
    'marketing','Marketing & Advertising',
    'attributes','Product Attributes & Options',
    'livestream','Livestream & Video Shopping',
    'navigation','Navigation & Site Structure',
    'omnichannel','Omnichannel & Composable Commerce',
    'ready_sites','Ready Sites & Themes',
    'marketplaces','Marketplaces',
    'import_export','Import, Export & Data Exchange',
    'notifications','Notifications, Email & SMS',
    'subscriptions','Subscriptions & Recurring Payments'
));

INSERT INTO `cot_marketprofilter_i18n` (`i18n_param_id`, `i18n_locale`, `i18n_title`, `i18n_values`) VALUES
(7, 'ua', 'Призначення або категорія', JSON_OBJECT(
    '1c','Інтеграція з 1С, ERP та складським обліком',
    'ai','Генеративний AI, чатботи та персоналізація',
    'ads','Реклама та просування',
    'geo','Робота з картами та Geo IP',
    'pwa','Мобільні додатки та PWA',
    'seo','SEO та оптимізація',
    'blog','Блоги, новини, статті',
    'cart','Кошик та оформлення замовлення',
    'i18n','Багатомовність та переклад (i18n)',
    'admin','Адміністрування та управління',
    'ar_vr','AR/VR та 3D-візуалізація товарів',
    'cache','Кешування, стиснення та прискорення сайту',
    'feeds','Стрічки товарів',
    'games','Ігри та клани',
    'media','Робота з медіа (фото, відео, файли)',
    'other','Інше',
    'utils','Утиліти та інструменти',
    'vqmod','VQMod, скрипти після установки та модифікатори',
    'design','Меню, дизайн та зовнішній вигляд',
    'editor','Редактори та робота з текстом',
    'events','Публікації та заходи',
    'prices','Робота з акціями, знижками та цінами',
    'search','Пошук',
    'social','Соціальна комерція та інтеграції з соцмережами',
    'totals','Підсумкові суми та облік у замовленні',
    'bonuses','Бонуси, купони, програми лояльності',
    'booking','Бронювання та календарі',
    'bundles','Серії, комплекти та бандли',
    'compare','Порівняння товарів, обране та закладки',
    'filters','Фільтри',
    'parsers','Парсери та збір даних',
    'reports','Звіти та аналітика',
    'reviews','Відгуки та UGC',
    'delivery','Доставки та служби доставки',
    'feedback','Зворотний зв\'язок, форми та онлайн-дзвінки',
    'payments','Платіжні системи та шлюзи',
    'security','Безпека та автентифікація',
    'telegram','Telegram-інтеграції та міні-додатки',
    'galleries','Слайдшоу, банери, галереї',
    'marketing','Маркетинг та реклама',
    'attributes','Характеристики, атрибути та опції товарів',
    'livestream','Livestream та відео-шопінг',
    ' Parad navigation','Навігація та структура сайту',
    'omnichannel','Омніканальність та composable commerce',
    'ready_sites','Готові сайти та теми',
    'marketplaces','Торгові майданчики (маркетплейси)',
    'import_export','Імпорт, експорт та обмін даними',
    'notifications','Сповіщення, розсилки, email та SMS',
    'subscriptions','Підписки та регулярні платежі'
));

-- 4. Категория расширения (param_id = 8, новый параметр из дампа)
INSERT INTO `cot_marketprofilter_params`
(`param_id`, `param_name`, `param_title`, `param_type`, `param_values`, `param_category`, `param_active`) VALUES
(8, '001_cot-CatExt', 'Категория расширения', 'checkbox', JSON_ARRAY('admin','security','blog','bonuses','booking','ai','games','import_export','cache','cart','marketing','design','pwa','i18n','navigation','feedback','notifications','reviews','reports','payments','search','subscriptions','events','prices','geo','media','editor','ads','galleries','social','compare','telegram','marketplaces','filters','attributes','utils','seo'), 'plugs', 1);

-- Переводы для param_id = 8 (разбиты по языкам)
INSERT INTO `cot_marketprofilter_i18n` (`i18n_param_id`, `i18n_locale`, `i18n_title`, `i18n_values`) VALUES
(8, 'ru', 'Категория расширения', JSON_OBJECT(
    'ai','AI, ИИ-инструменты, чатботы',
    'ads','Реклама и продвижение',
    'geo','Работа с картами и Geo IP',
    'pwa','Мобильные приложения и PWA',
    'seo','SEO и оптимизация',
    'blog','Блоги, новости, статьи',
    'cart','Корзина, оформление заказов',
    'i18n','Многоязычность и перевод (i18n)',
    'admin','Администрирование и управление',
    'cache','Кэширование, сжатие и ускорение сайта',
    'games','Игры и кланы',
    'media','Работа с медиа (фото, видео, файлы)',
    'utils','Утилиты и инструменты',
    'design','Меню, дизайн и внешний вид',
    'editor','Редакторы и работа с текстом',
    'events','Публикации и мероприятия',
    'prices','Работа с акциями, скидками и ценами',
    'search','Поиск',
    'social','Социальная сеть и интеграции',
    'bonuses','Бонусы, купоны, программы лояльности',
    'booking','Бронирование и календари',
    'compare','Избранное и закладки',
    'filters','Фильтры',
    'reports','Отчёты и аналитика',
    'reviews','Отзывы, комментарии и UGC',
    'feedback','Обратная связь, формы и онлайн-звонки',
    'payments','Платёжные системы и биллинг',
    'security','Безопасность и аутентификация',
    'telegram','Telegram-интеграции и мини-приложения',
    'galleries','Слайдшоу, баннеры, галереи',
    'marketing','Маркетинг и реклама',
    'attributes','Характеристики, Атрибуты и Опции товаров',
    'navigation','Навигация и структура сайта',
    'marketplaces','Торговые площадки (маркетплейсы)',
    'import_export','Импорт, экспорт и обмен данными',
    'notifications','Оповещения, рассылки, email и SMS',
    'subscriptions','Подписки и рассылки'
));

INSERT INTO `cot_marketprofilter_i18n` (`i18n_param_id`, `i18n_locale`, `i18n_title`, `i18n_values`) VALUES
(8, 'en', 'Category Extentions', JSON_OBJECT(
    'ai','AI, artificial intelligence tools, chatbots',
    'ads','Advertising and promotion',
    'geo','Maps and Geo IP integration',
    'pwa','Mobile apps and PWAs',
    'seo','SEO and optimization',
    'blog','Blogs, news, articles',
    'cart','Cart and order processing',
    'i18n','Multilingual support and translation (i18n)',
    'admin','Administration and management',
    'cache','Caching, compression, and site acceleration',
    'games','Games and clans',
    'media','Media management (photos, videos, files)',
    'utils','Utilities and tools',
    'design','Menus, design, and appearance',
    'editor','Editors and text management',
    'events','Posts and events',
    'prices','Deals, discounts, and pricing',
    'search','Search',
    'social','Social networks and integrations',
    'bonuses','Bonuses, coupons, loyalty programs',
    'booking','Booking and calendars',
    'compare','Favorites and bookmarks',
    'filters','Filters',
    'reports','Reports and analytics',
    'reviews','Reviews, comments, and user-generated content',
    'feedback','Feedback, forms, and online calls',
    'payments','Payment systems and billing',
    'security','Security and authentication',
    'telegram','Telegram integrations and mini-apps',
    'galleries','Slideshows, banners, and galleries',
    'marketing','Marketing and advertising',
    'attributes','Product characteristics, attributes, and options',
    'navigation','Navigation and site structure',
    'marketplaces','Marketplaces',
    'import_export','Import, export, and data exchange',
    'notifications','Notifications, email and SMS campaigns',
    'subscriptions','Subscriptions and newsletters'
));

INSERT INTO `cot_marketprofilter_i18n` (`i18n_param_id`, `i18n_locale`, `i18n_title`, `i18n_values`) VALUES
(8, 'ua', 'Категорії розширень', JSON_OBJECT(
    'ai','AI, інструменти штучного інтелекту, чатботи',
    'ads','Реклама та просування',
    'geo','Робота з картами та Geo IP',
    'pwa','Мобільні додатки та PWA',
    'seo','SEO та оптимізація',
    'blog','Блоги, новини, статті',
    'cart','Кошик та обробка замовлень',
    'i18n','Багатомовність та переклад (i18n)',
    'admin','Адміністрування та управління',
    'cache','Кешування, стиснення та прискорення сайту',
    'games','Ігри та кланові системи',
    'media','Медіа (фото, відео, файли)',
    'utils','Утиліти та інструменти',
    'design','Меню, дизайн та зовнішній вигляд',
    'editor','Редактори та робота з текстом',
    'events','Публікації та події',
    'prices','Акції, знижки та ціни',
    'search','Пошук',
    'social','Соціальні мережі та інтеграції',
    'bonuses','Бонуси, купони, програми лояльності',
    'booking','Бронювання та календарі',
    'compare','Вибране та закладки',
    'filters','Фільтри',
    'reports','Звіти та аналітика',
    'reviews','Відгуки, коментарі та контент користувачів',
    'feedback','Зворотний зв\'язок, форми та онлайн дзвінки',
    'payments','Платіжні системи та білінг',
    'security','Безпека та аутентифікація',
    'telegram','Інтеграції Telegram та міні-додатки',
    'galleries','Слайдшоу, банери та галереї',
    'marketing','Маркетинг та реклама',
    'attributes','Характеристики, атрибути та опції товарів',
    'navigation','Навігація та структура сайту',
    'marketplaces','Маркетплейси',
    'import_export','Імпорт, експорт та обмін даними',
    'notifications','Сповіщення, email та SMS-розсилки',
    'subscriptions','Підписки та розсилки'
));

-- ===========================
-- Примеры значений у товаров (из дампа)
-- ===========================
INSERT INTO `cot_marketprofilter_params_values` (`fieldmrkt_id`, `param_id`, `param_value`) VALUES
(15, 5, '3.0.x.x'),
(15, 6, 'free'),
(15, 7, 'media'),
(16, 5, '3.0.x.x'),
(16, 6, 'free'),
(16, 7, 'design'),
(17, 5, '3.0.x.x'),
(17, 6, 'paid_download'),
(17, 7, 'media'),
(18, 6, 'free'),
(18, 8, 'utils');