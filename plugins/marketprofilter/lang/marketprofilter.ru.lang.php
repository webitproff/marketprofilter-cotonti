<?php
/**
 * Russian Language File for Market PRO Filter plugin for CMF Cotonti v.1+, PHP v.8.5+, MySQL v.8.0+
 * Filename: marketprofilter.ru.lang.php
 * Purpose: Russian localization for the Market PRO Filter plugin. Defines admin interface and forms strings.
 * Date=July 9Th, 2026
 *
 * ReadMeMore:              https://abuyfile.com/market/cotonti/plugs/market-pro-filter 
 * Support:                 https://abuyfile.com/forums/cotonti/custom/plugs/marketprofilter
 *
 * Plugin Market PRO Filter (Source code):  https://github.com/webitproff/marketprofilter-cotonti
 * Module Market PRO (Source code):         https://github.com/webitproff/marketpro-cotonti
 *
 * @package marketprofilter
 * @version 3.5.1
 * @author webitproff
 * @copyright Copyright (c) webitproff 2026 https://github.com/webitproff/
 * @license BSD
 */
defined('COT_CODE') or die('Wrong URL.');

/**
 * Plugin Config
 */

$L['cfg_marketprofilter_defaultlang'] = 'Код языка по умолчанию для фильтра';
$L['cfg_marketprofilter_log_enable'] = 'Включить ведение журнала и логирование';

/**
 * Plugin Info
 */
$L['info_name'] = 'Market PRO Filter';
$L['info_desc'] = 'Гибкая фильтрация товаров и услуг в списках категории по индивидуальным параметрам или характеристикам, в рамках конкретной категории или каталога в целом';
$L['info_notes'] = '<span class="text-danger fw-bold">Перед установкой плагина обязательно создать категорию товаров с кодом <code>electric-scooters</code> чтобы корректно встали демонстрационные данные фильтра</span>';


// АДМИНКА.
$L['marketprofilter_admin_title'] = 'Управление параметрами фильтрации';
$L['marketprofilter_param_name'] = 'Код параметра';
$L['marketprofilter_add_param'] = 'Добавление параметра';
$L['marketprofilter_edit_param'] = 'Редактирование параметра';
$L['marketprofilter_param_name_hint'] = 'Уникальный код (например, power, battery_capacity)';
$L['marketprofilter_param_title'] = 'Название параметра';
$L['marketprofilter_param_type'] = 'Тип параметра';
$L['marketprofilter_param_values'] = 'Значения параметра (JSON)';
$L['marketprofilter_param_values_hint'] = 'Для диапазона: {"min":0,"max":100}; для списка/чекбоксов: ["значение1","значение2"]';
$L['marketprofilter_param_active'] = 'Активен';
$L['marketprofilter_param_category'] = 'установить категорию для параметра';
$L['marketprofilter_param_category_hint'] = 'Категорию выбирать не обязательно';
$L['marketprofilter_existing_params'] = 'Существующие параметры';
$L['marketprofilter_id'] = 'ID';
$L['marketprofilter_actions'] = 'Действия';
$L['marketprofilter_confirm_delete'] = 'Вы уверены, что хотите удалить этот параметр?';
$L['marketprofilter_range'] = 'Диапазон';
$L['marketprofilter_radio'] = 'Радиокнопки';
$L['marketprofilter_select'] = 'Выпадающий список';
$L['marketprofilter_checkbox'] = 'Чекбоксы';
$L['marketprofilter_from'] = 'От';
$L['marketprofilter_to'] = 'До';
$L['marketprofilter_reset'] = 'Сбросить фильтры';
$L['marketprofilter_apply'] = 'Применить фильтры';
$L['marketprofilter_price'] = 'Диапазон цен';
$L['marketprofilter_cats'] = 'Категории';
$L['marketprofilter_sort'] = 'Сортировать по';
$L['marketprofilter_examples'] = 'Примеры';
$L['market_mostrelevant'] = 'Наиболее релевантные';
$L['market_costasc'] = 'Цена: по возрастанию';
$L['market_costdesc'] = 'Цена: по убыванию';
$L['marketprofilter_paramsItem'] = 'Характеристики и свойства';
$L['marketprofilter_translations'] = 'Переводы';
$L['marketprofilter_param_values_translated'] = 'Перевод значений';
$L['marketprofilter_i18n_values_hint'] = 'Формат: {"ключ":"перевод","ключ2":"перевод2"}. Ключи должны совпадать с param_values';
$L['marketprofilter_error_invalid_data'] = 'Некорректные данные параметра';
$L['marketprofilter_error_range_format'] = 'Для типа "Диапазон" нужен JSON: {"min":X,"max":Y}';
$L['marketprofilter_error_values_format'] = 'Значения должны быть массивом: ["значение1","значение2"]';
$L['marketprofilter_param_added'] = 'Параметр успешно добавлен';
$L['marketprofilter_param_updated'] = 'Параметр успешно обновлён';
$L['marketprofilter_param_deleted'] = 'Параметр удалён';
$L['marketprofilter_Hide_Filter'] = 'Скрыть фильтры';
$L['marketprofilter_Show_Filter'] = 'Показать фильтры';

// ==== admin tpl ===
$L['marketprofilter_tab_list'] = 'Список';
$L['marketprofilter_tab_add']  = 'Добавить';
$L['marketprofilter_tab_edit'] = 'Редактировать';
$L['marketprofilter_filter']   = 'Фильтр';
$L['marketprofilter_all_categories'] = 'Все категории';
$L['marketprofilter_uncategorized']  = 'Без категории';
// ==== admin tpl ===

$L['marketprofilter_param_superadmin'] = 'Только для администраторов';
$L['marketprofilter_param_superadmin_hint'] = 'Если отмечено, этот параметр будет виден и доступен для фильтрации только пользователям с правами администратора (группа 5).';
$L['marketprofilter_param_helpinfo'] = 'Подсказка / Пояснение';
$L['marketprofilter_param_helpinfo_hint'] = 'Небольшой текст-пояснение, который будет показан рядом с параметром в форме фильтра.';
$L['marketprofilter_param_superadmin_short'] = '🔒 Админ';
$L['marketprofilter_param_helpinfo_short'] = 'Подсказка';
$L['marketprofilter_foldall'] = 'Свернуть список';
$L['marketprofilter_unfoldall'] = 'Развернуть список';
$L['marketprofilter_select_param_value_not_selected'] = 'Я не выбранная!';

// АДМИНКА. СТРОКИ ДЛЯ МУЛЬТИЯЗЫЧНОСТИ
$L['marketprofilter_i18n_title_ru'] = 'Название параметра (RU)';
$L['marketprofilter_i18n_title_en'] = 'Название параметра (EN)';
$L['marketprofilter_i18n_title_ua'] = 'Название параметра (UA)';
$L['marketprofilter_i18n_values_ru'] = 'Перевод значений (RU)';
$L['marketprofilter_i18n_values_en'] = 'Перевод значений (EN)';
$L['marketprofilter_i18n_values_ua'] = 'Перевод значений (UA)';

$L['marketprofilter_adminTitle'] = 'Фильтр товаров Market PRO Filter Плагин для Cotonti CMF';
$L['marketprofilter_adminHelp'] = 'Подробная инструкция по заполнению полей параметров фильтра:
<ul>
<li><b>Код параметра</b> — уникальный системный идентификатор параметра. Используйте только латинские буквы, цифры и символ подчёркивания без пробелов. Например: <i>power</i>, <i>battery_capacity</i>. Этот код будет использоваться в базе данных и в коде, поэтому не должно быть дубликатов.</li>
<li><b>Название параметра</b> — читаемое название, которое увидят пользователи в интерфейсе сайта. Например: <i>Мощность</i>, <i>Ёмкость батареи</i>.</li>
<li><b>Тип параметра</b> — выберите тип значения:
    <ul>
        <li><i>Диапазон</i> — для числовых параметров с минимальным и максимальным значением, например, цена, вес;</li>
        <li><i>Выпадающий список</i> — для выбора одного варианта из списка фиксированных значений;</li>
        <li><i>Чекбоксы</i> — для выбора одного или нескольких вариантов из списка.</li>
    </ul>
</li>
<li><b>Значения параметра (JSON)</b> — в этом поле указываются допустимые значения параметра в формате JSON:
    <ul>
        <li>Для типа <i>Диапазон</i> необходимо указать объект с двумя свойствами <code>min</code> и <code>max</code>, например: <code>{"min":0,"max":100}</code>. Значения должны быть числами, <code>min</code> меньше или равно <code>max</code>.</li>
        <li>Для типов <i>Выпадающий список</i> и <i>Чекбоксы</i> укажите массив строк с возможными вариантами, например: <code>["Красный","Зелёный","Синий"]</code>. Каждый элемент массива — отдельное значение.</li>
    </ul>
    <p><b>Важно:</b> JSON должен быть строго корректным:
        <ul>
            <li>Используйте двойные кавычки для ключей и строковых значений;</li>
            <li>Не ставьте лишние запятые после последнего элемента;</li>
            <li>Структура должна точно соответствовать примерам выше.</li>
        </ul>
        Для проверки корректности JSON используйте онлайн-валидаторы, например <a href="https://jsonlint.com" target="_blank" rel="noopener noreferrer">jsonlint.com</a>. Некорректный JSON приведёт к ошибкам при сохранении или работе фильтра.</p>
</li>
<li><b>Активен</b> — переключатель, включающий или отключающий параметр фильтра на сайте. Если параметр неактивен, он не будет отображаться пользователям.</li>
</ul>';

// FRONTEND. Пользовательская часть сайта
$L['marketprofilter_found_items'] = 'Найдено {COUNT} позиций';
$L['marketprofilter_no_items'] = 'Товаров по заданным параметрам не найдено';
$L['marketprofilter_market_paramsItem_desc'] = 'и его характеристики, названия параметров и значения в фильтре товаров, для осуществления поиска на сайте в пределах своей главной категории.';
$L['marketprofilter_market_list_help'] = '<strong>Фильтр строгого соответствия комбинации параметров.</strong>
<ul>
<li><strong>Не выбирайте сразу много параметров.</strong></li>
<li>Если задать множество параметров сразу, то товара, который точно и одновременно соответствует всем выбранным параметрам, может просто не быть.</li>
<li><strong>Рекомендуется делать так:</strong>
    <ul>
        <li>Выберите один <code>главный параметр для вас</code></li>
        <li>примените фильтр и посмотрите результаты</li>
        <li>Потом добавляйте <code>следующий параметр</code> и фильтруйте снова.</li>
        <li>Если нужно воспользуйтесь кнопкой <i><strong>Очистить фильтр</strong></i> и начните снова.</li>
    </ul>
</li>
</ul>';
$L['marketprofilter_market_list_exist_param_title'] = 'Товар имеет свойства и параметры для поиска через фильтр';

$L['marketprofilter_param_multicats'] = 'Дополнительные категории для фильтра';
$L['marketprofilter_param_multicats_hint'] = 'Отметьте дочерние категории, в которых этот параметр также будет отображаться. Работает только при активном плагине Multicatmarket.';
$L['marketprofilter_param_multicats_short'] = 'Multicats';
