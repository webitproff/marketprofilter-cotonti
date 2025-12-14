<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=market.list.tags
 * Tags=market.list.tpl:{MARKET_FILTER_FORM}
 * [END_COT_EXT]
 */
/**
 * Market PRO Filter plugin for CMF Cotonti Siena v.0.9.26, PHP v.8.4+, MySQL v.8.0+
 * Filename: marketprofilter.markettags.php
 * Purpose: 
 * Date=2025-12-14
 * @package marketprofilter
 * @version 2.2.1
 * @author webitproff
 * @copyright Copyright (c) webitproff 2025 https://github.com/webitproff/
 * @license BSD
 */

defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('marketprofilter', 'plug');

global $db, $db_x, $t, $c;

if (!$t) return;

$db_params = $db_x . 'marketprofilter_params';
$db_i18n   = $db_x . 'marketprofilter_i18n';

$t1 = new XTemplate(cot_tplfile(['marketprofilter', 'filterform'], 'plug'));

$current_cat = (isset($c) && is_string($c)) ? trim($c) : '';

$where_sql = $current_cat !== ''
    ? "(param_category = ? OR param_category = '')"
    : "param_category = ''";

$bind = $current_cat !== '' ? [$current_cat] : [];

$filter_params = $db->query("
    SELECT param_id, param_name, param_type, param_values, param_category
    FROM $db_params
    WHERE param_active = 1 AND $where_sql
    ORDER BY param_id ASC
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

    $t1->assign([
        'FILTER_PARAM_NAME'  => htmlspecialchars($param_name),
        'FILTER_PARAM_TITLE' => htmlspecialchars($title),
        'FILTER_PARAM_TYPE'  => $param_type,
    ]);

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

        // Подсчёт количества — теперь безопасно
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