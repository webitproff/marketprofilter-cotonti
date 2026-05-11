<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=market.list.tags
 * Tags=market.list.tpl:{MARKET_FILTER_FORM}
 * [END_COT_EXT]
 */
 
/**
 * Market PRO Filter plugin for CMF Cotonti v.1+, PHP v.8.4+, MySQL v.8.0+
 * Filename: marketprofilter.markettags.php
 * Purpose: Формирует и передаёт в шаблон market.list.tpl блок {MARKET_FILTER_FORM} 
 *          с формой фильтрации товаров по параметрам.
 *          Для каждого активного параметра (range/select/checkbox/radio) строятся
 *          элементы формы, подгружаются актуальные количества товаров с учётом
 *          уже выбранных фильтров (фасетный подсчёт) и формируются URL‑ы формы и сброса.
 *          и сообщения с результатами {MARKETFILTER_MESSAGE}
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



defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('marketprofilter', 'plug');

global $db, $db_x, $t, $c;

if (!$t) return;

$db_params = $db_x . 'marketprofilter_params';
$db_i18n   = $db_x . 'marketprofilter_i18n';

$current_cat = (isset($c) && is_string($c)) ? trim($c) : '';

// Шаблон фильтра: если для категории есть свой файл — используем его
$template_name = ['marketprofilter', 'filterform']; // дефолтный
if (!empty($current_cat)) {
    $custom_tpl = $current_cat; // structure_code
    $custom_path = ['marketprofilter', 'filterform', $custom_tpl];
    if (file_exists(cot_tplfile($custom_path, 'plug', true))) {
        $template_name = $custom_path;
    }
}
$t1 = new XTemplate(cot_tplfile($template_name, 'plug'));

$where_sql = $current_cat !== ''
    ? "(param_category = ? OR param_category = '')"
    : "param_category = ''";

$bind = $current_cat !== '' ? [$current_cat] : [];

/* ==== фильтр и сортировка списка параметров в форме */

// Если не админ – исключаем суперадминские параметры
$superadmin_cond = '';
if (!marketprofilter_is_admin()) {
    $superadmin_cond = " AND param_superadmin = 0";
}

$filter_params = $db->query("
    SELECT param_id, param_name, param_type, param_values, param_category, param_helpinfo
    FROM $db_params
    WHERE param_active = 1 AND $where_sql $superadmin_cond
    ORDER BY param_name ASC
", $bind)->fetchAll();


if (empty($filter_params)) {
    $t->assign([
        'MARKET_FILTER_FORM'         => '',
        'MARKETFILTER_MESSAGE'       => '',
        'MARKETFILTER_MESSAGE_CLASS' => '',
    ]);
    return;
}

foreach ($filter_params as $param) {
    $param_id       = (int)$param['param_id'];
    $param_name     = $param['param_name'];
    $param_type     = $param['param_type'];
    $param_category = $param['param_category'] ?? ''; // <-- ИСПРАВЛЕНО
    $values_raw     = json_decode($param['param_values'], true);

    if (!is_array($values_raw)) continue;

    $input = cot_import("filter_$param_name", 'G', $param_type === 'checkbox' ? 'ARR' : 'TXT');

    $title = marketprofilter_get_title($param_id, Cot::$usr['lang'] ?? 'ru');
	$helpinfo = marketprofilter_get_helpinfo($param_id, Cot::$usr['lang'] ?? 'ru');
    $t1->assign([
        'FILTER_PARAM_NAME'  => htmlspecialchars($param_name),
        'FILTER_PARAM_TITLE' => htmlspecialchars($title),
        'FILTER_PARAM_TYPE'  => $param_type,
		//'FILTER_PARAM_HELP'  => htmlspecialchars($helpinfo),   // подсказка
		'FILTER_PARAM_HELP'  => $helpinfo,
    ]);
	
/* //'FILTER_PARAM_HELP'  => htmlspecialchars($helpinfo),   // подсказка
'FILTER_PARAM_HELP'  => $helpinfo,
Текст сохранится в БД как HTML, 
а на сайте будет выводиться с HTML-тегами благодаря убранному htmlspecialchars().
Важно: это безопасно, так как доступ к редактированию параметров есть только у администраторов сайта. 
Обычные пользователи не могут вставлять HTML. 
*/


    if ($param_type === 'range') {
        $value = $input ? floatval($input) : 0;
        $t1->assign([
            'FILTER_PARAM_VALUE_MAX' => $value,
            'FILTER_PARAM_MIN'       => $values_raw['min'] ?? 0,
            'FILTER_PARAM_MAX'       => $values_raw['max'] ?? 10000,
        ]);
        $t1->parse('FILTER_FORM.FILTER_PARAM.RANGE');

    } else {
        $list_block = strtoupper($param_type) . '_LIST';
		// Подсчёт количества, обновляемый после применения параметров фильтра
		$counts = marketprofilter_get_faceted_counts($param_id, $current_cat);
		/* 
        // Подсчёт количества. Старый метдо до появления функции marketprofilter_get_faceted_counts
        $counts = [];
        if (!empty($values_raw)) {
            $vals_esc = implode(',', array_map([$db, 'quote'], $values_raw));
            $cat_cond = ($param_category === '' && $current_cat !== '')
                ? "AND m.fieldmrkt_cat = " . $db->quote($current_cat)
                : '';

            $sql = "SELECT v.param_value, COUNT(DISTINCT v.fieldmrkt_id) AS cnt
                    FROM {$db_x}marketprofilter_params_values v
                    INNER JOIN {$db_x}market m ON m.fieldmrkt_id = v.fieldmrkt_id
                    WHERE v.param_id = $param_id AND v.param_value IN ($vals_esc) $cat_cond
                    GROUP BY v.param_value";

            $res = $db->query($sql)->fetchAll(PDO::FETCH_KEY_PAIR);
            foreach ($values_raw as $v) {
                $counts[$v] = $res[$v] ?? 0;
            }
        } 
		*/

        foreach ($values_raw as $key) {
            $display_text = marketprofilter_get_value($param_id, $key, Cot::$usr['lang'] ?? 'ru');

            $is_selected = $input && (
                $param_type === 'checkbox'
                    ? in_array($key, (array)$input, true)
                    : ((string)$key === (string)$input)
            );

            $t1->assign([
                'FILTER_PARAM_OPTION_VALUE'    => htmlspecialchars($key),
                'FILTER_PARAM_OPTION_TEXT'     => htmlspecialchars($display_text),
                'FILTER_PARAM_OPTION_SELECTED' => ($param_type === 'select' && $is_selected) ? 'selected' : '',
                'FILTER_PARAM_CHECKED'         => ($is_selected && in_array($param_type, ['checkbox','radio'])) ? 'checked' : '',
                'FILTER_PARAM_OPTION_COUNT'    => $counts[$key] ?? 0,
            ]);
            $t1->parse("FILTER_FORM.FILTER_PARAM.$list_block");
        }
        $t1->parse("FILTER_FORM.FILTER_PARAM." . strtoupper($param_type));
    }

    $t1->parse('FILTER_FORM.FILTER_PARAM');
}

//$search_url = cot_url('market', $current_cat !== '' ? ['c' => $current_cat] : []);
//$reset_url  = cot_url('market', $current_cat !== '' ? ['c' => $current_cat] : []);
// Базовые параметры (категория)
$base_params = $current_cat !== '' ? ['c' => $current_cat] : [];

// Все текущие GET-параметры кроме пагинации
$current_get = $_GET;
unset($current_get['d'], $current_get['dc']);

// URL формы — сохраняет все фильтры
$search_url = cot_url('market', $base_params + $current_get);

// Сброс — чистый URL категории
$reset_url = cot_url('market', $base_params);
$t1->assign([
    'SEARCH_ACTION_URL' => $search_url,
    'FILTER_RESET_URL'  => $reset_url,
]);

$t1->parse('FILTER_FORM');
$form = $t1->text('FILTER_FORM');

$t->assign([
    'MARKET_FILTER_FORM'         => $form,
    'MARKETFILTER_MESSAGE'       => $L['marketprofilter_message'] ?? '',
    'MARKETFILTER_MESSAGE_CLASS' => $L['marketprofilter_message_class'] ?? '',
]);
