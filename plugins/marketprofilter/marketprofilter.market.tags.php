<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=market.tags
 * Tags=market.tpl:{MARKET_FILTER_PARAMS}
 * [END_COT_EXT]
 */
 
/**
 * Market PRO Filter plugin for CMF Cotonti v.1+, PHP v.8.5+, MySQL v.8.0+
 * Filename: marketprofilter.market.tags.php
 * Purpose: Добавляет в шаблон карточки товара (market.tpl) блок {MARKET_FILTER_PARAMS}
 *          со списком параметров фильтра, присвоенных данному товару.
 *          Для каждого параметра выводится локализованное название и отформатированное значение
 *          (с учётом типа: select, checkbox, range, radio) на языке пользователя.
 *          Также передаются подсказки (helpinfo) и техническое имя параметра.
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



defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('marketprofilter', 'plug');

global $db, $db_x, $t, $item;

if (!$t) {
    marketprofilter_log('Ошибка: шаблон $t не определён');
    return;
}

// Получаем fieldmrkt_id
$fieldmrkt_id = isset($item['fieldmrkt_id']) ? (int)$item['fieldmrkt_id'] : cot_import('id', 'G', 'INT');
marketprofilter_log("fieldmrkt_id = $fieldmrkt_id");

if ($fieldmrkt_id <= 0) {
    marketprofilter_log("Ошибка: fieldmrkt_id не определён или равен 0");
    return;
}

$db_params = $db_x . 'marketprofilter_params';
$db_values = $db_x . 'marketprofilter_params_values';

// Текущий язык (работает даже без авторизации)
$current_lang = Cot::$usr['lang'] ?: (Cot::$cfg['lang'] ?? 'ru');

// Получаем активные параметры
$params_all = $db->query("
    SELECT param_id, param_name, param_type, param_superadmin
    FROM $db_params
    WHERE param_active = 1
    ORDER BY param_name ASC
")->fetchAll();

$params = [];
foreach ($params_all as $p) {
    if (!marketprofilter_is_admin() && $p['param_superadmin'] == 1) {
        continue;
    }
    $params[] = $p;
}



marketprofilter_log("Найдено активных параметров: " . count($params));

if (empty($params)) {
    return;
}

// Получаем сохранённые значения для товара
$saved_all = [];
$rows = $db->query("
    SELECT param_id, param_value
    FROM $db_values
    WHERE fieldmrkt_id = ?
", [$fieldmrkt_id])->fetchAll();

marketprofilter_log("Найдено значений для fieldmrkt_id=$fieldmrkt_id: " . count($rows));

foreach ($rows as $row) {
    $saved_all[(int)$row['param_id']][] = $row['param_value'];
}

// Формируем и выводим параметры
foreach ($params as $param) {
    $param_id   = (int)$param['param_id'];
    $param_name = $param['param_name'];
    $param_type = $param['param_type'];

    // Переведённый заголовок
    $title = marketprofilter_get_title($param_id, $current_lang);
	$helpinfo = marketprofilter_get_helpinfo($param_id, $current_lang);
    // Значения товара
    $saved_values = $saved_all[$param_id] ?? [];

    // Форматируем с переводом (передаём язык!)
    $formatted_value = marketprofilter_format_param_value($param_type, $saved_values, $param_name, $param_id, $current_lang);

    marketprofilter_log("Параметр $param_name ($param_type): $formatted_value");

    if ($formatted_value !== '') {
		$t->assign([
			'PARAM_TITLE' => htmlspecialchars($title),
			//'PARAM_VALUE' => htmlspecialchars($formatted_value),
			'PARAM_VALUE' => ($param_type === 'checkbox')
				? $formatted_value                     // HTML-список, уже содержит экранированные значения
				: htmlspecialchars($formatted_value),
			//'PARAM_HELP'  => htmlspecialchars($helpinfo),
			'PARAM_HELP'  => $helpinfo,   // без экранирования, чтобы HTML работал
			'PARAM_NAME'  => htmlspecialchars($param_name)
		]);
        $t->parse('MAIN.MARKET_FILTER_PARAMS');
    }
}

marketprofilter_log("Передано параметров в шаблон: " . count($params));
