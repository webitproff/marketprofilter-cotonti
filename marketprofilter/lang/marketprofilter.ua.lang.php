<?php
/**
 * Ukrainian Language File for Market PRO Filter plugin for CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0
 * Filename: marketprofilter.ua.lang.php
 * Purpose: Ukrainian localization for the Market PRO Filter plugin. Defines admin interface and forms strings.
 * Date: 2025-12-14
 * @package marketprofilter
 * @version 2.2.8
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL.');

/**
 * Plugin Config
 */

$L['cfg_marketprofilter_log_enable'] = 'Увімкнути ведення журналу та логування';

/**
 * Plugin Info
 */
$L['info_name'] = 'Market PRO Filter';
$L['info_desc'] = 'Гнучка фільтрація товарів і послуг у списках категорій за індивідуальними параметрами або характеристиками в межах окремої категорії або всього каталогу';
$L['info_notes'] = 'Потрібно: модуль <code>Market PRO v.5+ by webitproff</code>, PHP 8.4+, MySQL 8.0+, Cotonti Siena v.0.9.26 +';


$L['marketprofilter_admin_title'] = 'Керування параметрами фільтрації';
$L['marketprofilter_param_name'] = 'Код параметра';
$L['marketprofilter_add_param'] = 'Додати параметр';
$L['marketprofilter_edit_param'] = 'Редагувати параметр';
$L['marketprofilter_param_name_hint'] = 'Унікальний код (наприклад, power, battery_capacity)';
$L['marketprofilter_param_title'] = 'Назва параметра';
$L['marketprofilter_param_type'] = 'Тип параметра';
$L['marketprofilter_param_values'] = 'Значення параметра (JSON)';
$L['marketprofilter_param_values_hint'] = 'Для діапазону: {"min":0,"max":100}; для списку/чекбоксів: ["значення1","значення2"]';
$L['marketprofilter_param_active'] = 'Активний';
$L['marketprofilter_param_category'] = 'Призначити категорію для параметра';
$L['marketprofilter_param_category_hint'] = 'Вибір категорії необов’язковий';
$L['marketprofilter_existing_params'] = 'Існуючі параметри';
$L['marketprofilter_id'] = 'ID';
$L['marketprofilter_actions'] = 'Дії';
$L['marketprofilter_confirm_delete'] = 'Ви впевнені, що хочете видалити цей параметр?';
$L['marketprofilter_range'] = 'Діапазон';
$L['marketprofilter_radio'] = 'Радіокнопки';
$L['marketprofilter_select'] = 'Випадаючий список';
$L['marketprofilter_checkbox'] = 'Чекбокси';
$L['marketprofilter_from'] = 'Від';
$L['marketprofilter_to'] = 'До';
$L['marketprofilter_reset'] = 'Скинути фільтри';
$L['marketprofilter_apply'] = 'Застосувати фільтри';
$L['marketprofilter_price'] = 'Діапазон цін';
$L['marketprofilter_cats'] = 'Категорії';
$L['marketprofilter_sort'] = 'Сортувати за';
$L['marketprofilter_examples'] = 'Приклади';
$L['market_mostrelevant'] = 'Найбільш релевантні';
$L['market_costasc'] = 'Ціна: за зростанням';
$L['market_costdesc'] = 'Ціна: за спаданням';
$L['marketprofilter_paramsItem'] = 'Характеристики та властивості';
$L['marketprofilter_translations'] = 'Переклади';
$L['marketprofilter_param_values_translated'] = 'Переклад значень';
$L['marketprofilter_i18n_values_hint'] = 'Формат: {"ключ":"переклад","ключ2":"переклад2"}. Ключі мають збігатися з param_values';
$L['marketprofilter_error_invalid_data'] = 'Некоректні дані параметра';
$L['marketprofilter_error_range_format'] = 'Для типу "Діапазон" потрібен JSON: {"min":X,"max":Y}';
$L['marketprofilter_error_values_format'] = 'Значення повинні бути масивом: ["значення1","значення2"]';
$L['marketprofilter_param_added'] = 'Параметр успішно додано';
$L['marketprofilter_param_updated'] = 'Параметр успішно оновлено';
$L['marketprofilter_param_deleted'] = 'Параметр видалено';

// ДОДАНІ РЯДКИ ДЛЯ БАГАТОМОВНОСТІ
$L['marketprofilter_i18n_title_ru'] = 'Назва параметра (RU)';
$L['marketprofilter_i18n_title_en'] = 'Назва параметра (EN)';
$L['marketprofilter_i18n_title_ua'] = 'Назва параметра (UA)';
$L['marketprofilter_i18n_values_ru'] = 'Переклад значень (RU)';
$L['marketprofilter_i18n_values_en'] = 'Переклад значень (EN)';
$L['marketprofilter_i18n_values_ua'] = 'Переклад значень (UA)';

$L['marketprofilter_found_items'] = 'Знайдено {COUNT} позицій';
$L['marketprofilter_no_items'] = 'Товарів за заданими параметрами не знайдено';

$L['marketprofilter_adminTitle'] = 'Market PRO Filter — плагін фільтрації товарів для Cotonti CMF';
$L['marketprofilter_adminHelp'] = 'Детальна інструкція щодо заповнення полів параметрів фільтра:
<ul>
<li><b>Код параметра</b> — унікальний системний ідентифікатор параметра. Використовуйте лише латинські літери, цифри та символ підкреслення без пробілів. Наприклад: <i>power</i>, <i>battery_capacity</i>. Цей код використовується в базі даних і в коді, тому дублікати не допускаються.</li>
<li><b>Назва параметра</b> — зрозуміла назва, яку користувачі побачать в інтерфейсі сайту. Наприклад: <i>Потужність</i>, <i>Ємність батареї</i>.</li>
<li><b>Тип параметра</b> — оберіть тип значення:
    <ul>
        <li><i>Діапазон</i> — для числових параметрів з мінімальним і максимальним значенням, наприклад ціна або вага;</li>
        <li><i>Випадаючий список</i> — для вибору одного варіанта з фіксованого списку значень;</li>
        <li><i>Чекбокси</i> — для вибору одного або кількох варіантів зі списку.</li>
    </ul>
</li>
<li><b>Значення параметра (JSON)</b> — у цьому полі задаються допустимі значення параметра у форматі JSON:
    <ul>
        <li>Для типу <i>Діапазон</i> необхідно вказати об’єкт з двома властивостями <code>min</code> та <code>max</code>, наприклад: <code>{"min":0,"max":100}</code>. Значення мають бути числовими, а <code>min</code> — меншим або рівним <code>max</code>.</li>
        <li>Для типів <i>Випадаючий список</i> і <i>Чекбокси</i> вкажіть масив рядків із можливими варіантами, наприклад: <code>["Червоний","Зелений","Синій"]</code>. Кожен елемент масиву — окреме значення.</li>
    </ul>
    <p><b>Важливо:</b> JSON має бути строго коректним:
        <ul>
            <li>Використовуйте подвійні лапки для ключів і рядкових значень;</li>
            <li>Не додавайте зайві коми після останнього елемента;</li>
            <li>Структура повинна точно відповідати наведеним прикладам.</li>
        </ul>
        Для перевірки коректності JSON використовуйте онлайн-валідатори, наприклад <a href="https://jsonlint.com" target="_blank" rel="noopener noreferrer">jsonlint.com</a>. Некоректний JSON призведе до помилок під час збереження або роботи фільтра.</p>
</li>
<li><b>Активний</b> — перемикач, який вмикає або вимикає параметр фільтра на сайті. Якщо параметр неактивний, він не відображатиметься користувачам.</li>
</ul>';
