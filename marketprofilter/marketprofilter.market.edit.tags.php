<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=market.edit.tags
 * Tags=market.edit.tpl:{MARKET_FORM_FILTER_PARAMS}
 * [END_COT_EXT]
 */


/**
 * Market PRO Filter plugin for CMF Cotonti v.1+, PHP v.8.4+, MySQL v.8.0+
 * Filename: marketprofilter.market.edit.tags.php
 * Purpose: выводим в шаблон market.edit.tpl формы для выбора значений, к которым принадлежит товар, что бы по ним срабатывал фильтр.
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
 

/* 	
	вот так в шаблоне market.edit.tpl
 * <!-- IF {PHP|cot_plugin_active('marketprofilter')} -->
 * <div class="col-12">
 * 	<label class="form-label fw-semibold"></label>		
 * 	{MARKET_FORM_FILTER_PARAMS}
 * </div>
 * <!-- ENDIF -->	
 */		


defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');
require_once cot_incfile('marketprofilter', 'plug');

global $db, $db_x;

if (!$t || empty($row_item)) {
    $t->assign('MARKET_FORM_FILTER_PARAMS', '');
    return;
}

$item_id = (int)$row_item['fieldmrkt_id'];
$current_cat = $row_item['fieldmrkt_cat'];
 
$db_params = $db_x . 'marketprofilter_params';
$db_values = $db_x . 'marketprofilter_params_values';

// Сохранённые значения
$saved_all = [];
if ($item_id > 0) {
    $rows = $db->query("SELECT param_id, param_value FROM $db_values WHERE fieldmrkt_id = ?", [$item_id])->fetchAll();
    foreach ($rows as $row) {
        $saved_all[(int)$row['param_id']][] = $row['param_value'];
    }
}

// Параметры для текущей категории
$params = $db->query("
    SELECT param_id, param_name, param_type, param_values
    FROM $db_params
    WHERE param_active = 1 AND (param_category = ? OR param_category = '')
    ORDER BY param_name ASC
", [$current_cat])->fetchAll();

if (empty($params)) {
    $t->assign('MARKET_FORM_FILTER_PARAMS', '');
    return;
}

// Передаём заголовок блока (можно использовать в шаблоне)
$t->assign('FILTER_PARAMS_HEADER', $L['marketprofilter_paramsItem'] ?? 'Параметры фильтра');
//$t->assign('MARKET_FORM_FILTER_PARAMS', '');
// Основной цикл по параметрам – теперь без HTML-строк
foreach ($params as $param) {
    $param_id   = (int)$param['param_id'];
    $param_name = $param['param_name'];
    $param_type = $param['param_type'];
    $values_raw = json_decode($param['param_values'], true);

    if (!is_array($values_raw)) continue;

    // Переведённый заголовок
    $title    = marketprofilter_get_title($param_id, Cot::$usr['lang'] ?? Cot::$cfg['lang'] ?? 'ru');
    $helpinfo = marketprofilter_get_helpinfo($param_id, Cot::$usr['lang'] ?? Cot::$cfg['lang'] ?? 'ru');
    $saved_values = $saved_all[$param_id] ?? [];

    // Формируем HTML элемента ввода (только для вставки в шаблон)
    $input = '';
    switch ($param_type) {
        case 'range':
            $saved = $saved_values[0] ?? '';
            if (strpos($saved, '-') !== false) {
                [, $maxTmp] = explode('-', $saved);
                $saved = $maxTmp;
            }
            $input = '<input type="number" name="marketprofilter['.$param_name.'][value]" value="'.htmlspecialchars($saved).'" class="form-control" placeholder="Введите число">';
            break;

        case 'select':
            $selected = $saved_values[0] ?? '';
            $options = [];
            foreach ($values_raw as $key) {
                $options[$key] = marketprofilter_get_value($param_id, $key, Cot::$usr['lang'] ?? Cot::$cfg['lang'] ?? 'ru');
            }
            $input = cot_selectbox($selected, "marketprofilter[$param_name]", array_keys($options), array_values($options), true, ['class' => 'form-select']);
            break;

        case 'checkbox':
            $checked = is_array($saved_values) ? $saved_values : [];
            $options = [];
            foreach ($values_raw as $key) {
                $options[$key] = marketprofilter_get_value($param_id, $key, Cot::$usr['lang'] ?? Cot::$cfg['lang'] ?? 'ru');
            }
            $input = cot_checklistbox($checked, "marketprofilter[$param_name][]", array_keys($options), array_values($options), ['class' => 'form-check-input']);
            break;

        case 'radio':
            $selected = $saved_values[0] ?? '';
            $options = [];
            foreach ($values_raw as $key) {
                $options[$key] = marketprofilter_get_value($param_id, $key, Cot::$usr['lang'] ?? Cot::$cfg['lang'] ?? 'ru');
            }
            $input = cot_radiobox($selected, "marketprofilter[$param_name]", array_keys($options), array_values($options), ['class' => 'form-check-input']);
            break;

        default:
            $value = $saved_values[0] ?? '';
            $input = '<input type="text" name="marketprofilter['.$param_name.']" value="'.htmlspecialchars($value).'" class="form-control">';
    }

    // Передаём данные в шаблон для одного параметра
    $t->assign([
        'FILTER_PARAM_TITLE'   => htmlspecialchars($title),
        'FILTER_PARAM_NAME'    => htmlspecialchars($param_name),
        'FILTER_PARAM_INPUT'   => $input,
        'FILTER_PARAM_HELP'    => $helpinfo,
        'FILTER_PARAM_HASHELP' => !empty($helpinfo) ? 1 : 0,
    ]);

    // Парсим дочерний блок MARKET_FORM_FILTER_PARAM (будет определён в market.edit.tpl) -- все дальше где-то не так написано
    $t->parse('MAIN.MARKET_FORM_FILTER_PARAMS.MARKET_FORM_FILTER_PARAM');
	
}
$t->parse('MAIN.MARKET_FORM_FILTER_PARAMS');