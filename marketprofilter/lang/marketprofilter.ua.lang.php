<?php
/**
 * Ukrainian Language File for Market PRO Filter plugin for CMF Cotonti v.1+, PHP v.8.4+, MySQL v.8.0+
 * Filename: marketprofilter.ua.lang.php
 * Purpose: Ukrainian localization for the Market PRO Filter plugin. Defines admin interface and forms strings.
 * Date=May 11Th, 2026
 *
 * ReadMeMore:              https://abuyfile.com/market/cotonti/plugs/market-pro-filter 
 * Support:                 https://abuyfile.com/forums/cotonti/custom/plugs/marketprofilter
 *
 * Plugin Market PRO Filter (Source code):  https://github.com/webitproff/marketprofilter-cotonti
 * Module Market PRO (Source code):         https://github.com/webitproff/marketpro-cotonti
 *
 * @package marketprofilter
 * @version 3.3.36
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 https://github.com/webitproff/
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

/**
 * Plugin Config
 */

$L['cfg_marketprofilter_defaultlang'] = 'Код мови за замовчуванням для фільтра';
$L['cfg_marketprofilter_log_enable'] = 'Увімкнути ведення журналу та логування';

/**
 * Plugin Info
 */
$L['info_name'] = 'Market PRO Filter';
$L['info_desc'] = 'Гнучка фільтрація товарів і послуг у списках категорії за індивідуальними параметрами або характеристиками, у межах конкретної категорії чи всього каталогу';
$L['info_notes'] = '<span class="text-danger fw-bold">Перед встановленням плагіна обов’язково створіть категорію товарів з кодом <code>electric-scooters</code>, щоб демонстраційні дані фільтра коректно додались</span>';


// АДМІНКА.
$L['marketprofilter_admin_title'] = 'Керування параметрами фільтрації';
$L['marketprofilter_param_name'] = 'Код параметра';
$L['marketprofilter_add_param'] = 'Додавання параметра';
$L['marketprofilter_edit_param'] = 'Редагування параметра';
$L['marketprofilter_param_name_hint'] = 'Унікальний код (наприклад, power, battery_capacity)';
$L['marketprofilter_param_title'] = 'Назва параметра';
$L['marketprofilter_param_type'] = 'Тип параметра';
$L['marketprofilter_param_values'] = 'Значення параметра (JSON)';
$L['marketprofilter_param_values_hint'] = 'Для діапазону: {"min":0,"max":100}; для списку/чекбоксів: ["значення1","значення2"]';
$L['marketprofilter_param_active'] = 'Активний';
$L['marketprofilter_param_category'] = 'Встановити категорію для параметра';
$L['marketprofilter_param_category_hint'] = 'Обирати категорію не обов’язково';
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
$L['marketprofilter_i18n_values_hint'] = 'Формат: {"ключ":"переклад","ключ2":"переклад2"}. Ключі повинні збігатися з param_values';
$L['marketprofilter_error_invalid_data'] = 'Некоректні дані параметра';
$L['marketprofilter_error_range_format'] = 'Для типу «Діапазон» потрібен JSON: {"min":X,"max":Y}';
$L['marketprofilter_error_values_format'] = 'Значення повинні бути масивом: ["значення1","значення2"]';
$L['marketprofilter_param_added'] = 'Параметр успішно додано';
$L['marketprofilter_param_updated'] = 'Параметр успішно оновлено';
$L['marketprofilter_param_deleted'] = 'Параметр видалено';

$L['marketprofilter_param_superadmin'] = 'Тільки для адміністраторів';
$L['marketprofilter_param_superadmin_hint'] = 'Якщо позначено, цей параметр буде видно та доступно для фільтрації лише користувачам з правами адміністратора (група 5).';
$L['marketprofilter_param_helpinfo'] = 'Підказка / Пояснення';
$L['marketprofilter_param_helpinfo_hint'] = 'Невеликий текст-пояснення, який буде показано поруч із параметром у формі фільтра.';
$L['marketprofilter_param_superadmin_short'] = '🔒 Адмін';
$L['marketprofilter_param_helpinfo_short'] = 'Підказка';

// АДМІНКА. РЯДКИ ДЛЯ БАГАТОМОВНОСТІ
$L['marketprofilter_i18n_title_ru'] = 'Назва параметра (RU)';
$L['marketprofilter_i18n_title_en'] = 'Назва параметра (EN)';
$L['marketprofilter_i18n_title_ua'] = 'Назва параметра (UA)';
$L['marketprofilter_i18n_values_ru'] = 'Переклад значень (RU)';
$L['marketprofilter_i18n_values_en'] = 'Переклад значень (EN)';
$L['marketprofilter_i18n_values_ua'] = 'Переклад значень (UA)';

$L['marketprofilter_adminTitle'] = 'Фільтр товарів Market PRO Filter Плагін для Cotonti CMF';
$L['marketprofilter_adminHelp'] = 'Детальна інструкція з заповнення полів параметрів фільтра:
<ul>
<li><b>Код параметра</b> — унікальний системний ідентифікатор параметра. Використовуйте лише латинські літери, цифри та символ підкреслення без пробілів. Наприклад: <i>power</i>, <i>battery_capacity</i>. Цей код буде використовуватися в базі даних та в коді, тому не повинно бути дублікатів.</li>
<li><b>Назва параметра</b> — зрозуміла назва, яку побачать користувачі в інтерфейсі сайту. Наприклад: <i>Потужність</i>, <i>Ємність батареї</i>.</li>
<li><b>Тип параметра</b> — оберіть тип значення:
    <ul>
        <li><i>Діапазон</i> — для числових параметрів з мінімальним і максимальним значенням, наприклад, ціна, вага;</li>
        <li><i>Випадаючий список</i> — для вибору одного варіанта зі списку фіксованих значень;</li>
        <li><i>Чекбокси</i> — для вибору одного або кількох варіантів зі списку.</li>
    </ul>
</li>
<li><b>Значення параметра (JSON)</b> — у цьому полі вказуються допустимі значення параметра у форматі JSON:
    <ul>
        <li>Для типу <i>Діапазон</i> необхідно вказати об’єкт з двома властивостями <code>min</code> і <code>max</code>, наприклад: <code>{"min":0,"max":100}</code>. Значення мають бути числами, <code>min</code> менше або дорівнює <code>max</code>.</li>
        <li>Для типів <i>Випадаючий список</i> та <i>Чекбокси</i> вкажіть масив рядків з можливими варіантами, наприклад: <code>["Червоний","Зелений","Синій"]</code>. Кожен елемент масиву — окреме значення.</li>
    </ul>
    <p><b>Важливо:</b> JSON має бути строго коректним:
        <ul>
            <li>Використовуйте подвійні лапки для ключів і рядкових значень;</li>
            <li>Не ставте зайвих ком після останнього елемента;</li>
            <li>Структура повинна точно відповідати прикладам вище.</li>
        </ul>
        Для перевірки коректності JSON використовуйте онлайн-валідатори, наприклад <a href="https://jsonlint.com" target="_blank" rel="noopener noreferrer">jsonlint.com</a>. Некоректний JSON призведе до помилок при збереженні або роботі фільтра.</p>
</li>
<li><b>Активний</b> — перемикач, що вмикає або вимикає параметр фільтра на сайті. Якщо параметр неактивний, він не відображатиметься користувачам.</li>
</ul>';

// FRONTEND. Публічна частина сайту
$L['marketprofilter_found_items'] = 'Знайдено {COUNT} позицій';
$L['marketprofilter_no_items'] = 'Товарів за заданими параметрами не знайдено';
$L['marketprofilter_market_paramsItem_desc'] = 'та його характеристики, назви параметрів і значення у фільтрі товарів на сайті в категорії';
$L['marketprofilter_market_list_help'] = '<strong>Фільтр суворої відповідності комбінації параметрів.</strong>
<ul>
<li><strong>Не обирайте одразу багато параметрів.</strong></li>
<li>Якщо задати багато параметрів одразу, то товару, який точно й одночасно відповідає всім вибраним параметрам, може просто не бути.</li>
<li><strong>Рекомендується робити так:</strong>
    <ul>
        <li>Оберіть один <code>головний параметр для вас</code></li>
        <li>застосуйте фільтр і перегляньте результати</li>
        <li>Потім додавайте <code>наступний параметр</code> і фільтруйте знову.</li>
        <li>Якщо потрібно, скористайтеся кнопкою <i><strong>Очистити фільтр</strong></i> і почніть спочатку.</li>
    </ul>
</li>
</ul>';
$L['marketprofilter_market_list_exist_param_title'] = 'Товар має властивості та параметри для пошуку через фільтр';
