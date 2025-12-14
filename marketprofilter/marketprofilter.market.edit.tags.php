<?php
/**
 * [BEGIN_COT_EXT]
 * Hooks=market.edit.tags
 * Tags=market.edit.tpl:{MARKET_FORM_FILTER_PARAMS}
 * [END_COT_EXT]
 */
defined('COT_CODE') or die('Wrong URL');

require_once cot_incfile('forms');
require_once cot_incfile('marketprofilter', 'plug');

global $db, $db_x, $t, $item;

if (!$t || empty($item) || empty($item['fieldmrkt_cat'])) {
    $t->assign('MARKET_FORM_FILTER_PARAMS', '');
    return;
}

$item_id = (int)$item['fieldmrkt_id'];
$current_cat = $item['fieldmrkt_cat'];

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
    ORDER BY param_id ASC
", [$current_cat])->fetchAll();

if (empty($params)) {
    $t->assign('MARKET_FORM_FILTER_PARAMS', '');
    return;
}

$filter_params_html = '<div class="border rounded p-4 mb-4 bg-light">';
$filter_params_html .= '<h5 class="mb-3">Характеристики товара</h5>';

foreach ($params as $param) {
    $param_id   = (int)$param['param_id'];
    $param_name = $param['param_name'];
    $param_type = $param['param_type'];
    $values_raw = json_decode($param['param_values'], true);

    if (!is_array($values_raw)) continue;

    // Переведённый заголовок
    $title = marketprofilter_get_title($param_id, Cot::$usr['lang'] ?? Cot::$cfg['lang'] ?? 'ru');

    $saved_values = $saved_all[$param_id] ?? [];

    $input = '';

    switch ($param_type) {
        case 'range':
            $min_val = $max_val = '';
            if (!empty($saved_values[0]) && strpos($saved_values[0], '-') !== false) {
                [$min_val, $max_val] = explode('-', $saved_values[0], 2);
                $min_val = $min_val === '' ? '' : (int)$min_val;
                $max_val = $max_val === '' ? '' : (int)$max_val;
            }
            $min_ph = $values_raw['min'] ?? '';
            $max_ph = $values_raw['max'] ?? '';
            $input = '
                <div class="row g-2">
                    <div class="col">
                        <input type="number" name="marketprofilter['.$param_name.'][min]" value="'.$min_val.'" class="form-control" placeholder="от '.$min_ph.'">
                    </div>
                    <div class="col">
                        <input type="number" name="marketprofilter['.$param_name.'][max]" value="'.$max_val.'" class="form-control" placeholder="до '.$max_ph.'">
                    </div>
                </div>';
            break;

        case 'select':
            $selected = $saved_values[0] ?? '';
            $options = [];
            foreach ($values_raw as $key) {
                $translated = marketprofilter_get_value($param_id, $key, Cot::$usr['lang'] ?? Cot::$cfg['lang'] ?? 'ru');
                $options[$key] = $translated;
            }
            $input = cot_selectbox($selected, "marketprofilter[$param_name]", array_keys($options), array_values($options), true, ['class' => 'form-select']);
            break;

        case 'checkbox':
            $checked = is_array($saved_values) ? $saved_values : [];
            $options = [];
            foreach ($values_raw as $key) {
                $translated = marketprofilter_get_value($param_id, $key, Cot::$usr['lang'] ?? Cot::$cfg['lang'] ?? 'ru');
                $options[$key] = $translated;
            }
            $input = cot_checklistbox($checked, "marketprofilter[$param_name][]", array_keys($options), array_values($options), ['class' => 'form-check-input']);
            break;

        case 'radio':
            $selected = $saved_values[0] ?? '';
            $options = [];
            foreach ($values_raw as $key) {
                $translated = marketprofilter_get_value($param_id, $key, Cot::$usr['lang'] ?? Cot::$cfg['lang'] ?? 'ru');
                $options[$key] = $translated;
            }
            $input = cot_radiobox($selected, "marketprofilter[$param_name]", array_keys($options), array_values($options), ['class' => 'form-check-input']);
            break;

        default:
            $value = $saved_values[0] ?? '';
            $input = '<input type="text" name="marketprofilter['.$param_name.']" value="'.htmlspecialchars($value).'" class="form-control">';
    }

    $filter_params_html .= '
        <div class="mb-3">
            <label class="form-label fw-bold">'.$title.'</label>
            '.$input.'
        </div>';
}

$filter_params_html .= '</div>';

$t->assign('MARKET_FORM_FILTER_PARAMS', $filter_params_html);