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
 * Date=May 17Th, 2026
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
    SELECT param_id, param_name, param_type, param_values, param_category, param_helpinfo, param_hidelistitem
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

// === УНИВЕРСАЛЬНАЯ ГЕНЕРАЦИЯ ТЕГОВ ДЛЯ ВСЕХ АКТИВНЫХ ПАРАМЕТРОВ (БЕЗ УЧЁТА КАТЕГОРИИ) ===
$all_params = $db->query("
    SELECT param_name, param_values
    FROM $db_params
    WHERE param_active = 1
")->fetchAll();

foreach ($all_params as $p) {
    $pname = $p['param_name'];
    $pvals = json_decode($p['param_values'], true);
    if (!is_array($pvals)) continue;
    
    $t->assign('PARAM_' . strtoupper($pname) . '_EXISTS', 1);
    
    foreach ($pvals as $val) {
        $safe_val = preg_replace('/[^a-zA-Z0-9_]/', '_', $val);
        $tag = 'PARAM_' . strtoupper($pname) . '_VALUE_' . strtoupper($safe_val) . '_EXISTS';
        $t->assign($tag, 1);
    }
}
// === КОНЕЦ БЛОКА ===

/* // Генерация универсальных тегов для всех параметров и значений
foreach ($filter_params as $param) {
    $param_name = $param['param_name'];
    $values_raw = json_decode($param['param_values'], true);
    if (!is_array($values_raw)) continue;

    // Тег: существует ли такой параметр (всегда 1, т.к. мы выбрали только активные)
    $t->assign('PARAM_' . strtoupper($param_name) . '_EXISTS', 1);

    // Для каждого значения из JSON создаём тег вида PARAM_ИМЯ_VALUE_ЗНАЧЕНИЕ_EXISTS
    foreach ($values_raw as $val) {
        // Очищаем значение для безопасного использования в имени тега
        $safe_val = preg_replace('/[^a-zA-Z0-9_]/', '_', $val);
        $tag_name = 'PARAM_' . strtoupper($param_name) . '_VALUE_' . strtoupper($safe_val) . '_EXISTS';
        $t->assign($tag_name, 1);
    }
} */
foreach ($filter_params as $param) {
    $param_id       = (int)$param['param_id'];
    $param_name     = $param['param_name'];
    $param_type     = $param['param_type'];
    $param_category = $param['param_category'] ?? '';
    $param_hidelist = !empty($param['param_hidelistitem']) ? 1 : 0;
    $values_raw     = json_decode($param['param_values'], true);

    if (!is_array($values_raw)) continue;

    $input = cot_import("filter_$param_name", 'G', $param_type === 'checkbox' ? 'ARR' : 'TXT');

    $title = marketprofilter_get_title($param_id, Cot::$usr['lang'] ?? 'ru');
    $helpinfo = marketprofilter_get_helpinfo($param_id, Cot::$usr['lang'] ?? 'ru');
    $is_color = (strpos($param_name, 'color_') === 0);

    $t1->assign([
        'FILTER_PARAM_NAME'     => htmlspecialchars($param_name),
        'FILTER_PARAM_TITLE'    => htmlspecialchars($title),
        'FILTER_PARAM_TYPE'     => $param_type,
        'FILTER_PARAM_HELP'     => $helpinfo,
        'FILTER_PARAM_IS_COLOR' => $is_color,
        'FILTER_PARAM_HIDELIST' => $param_hidelist,
    ]);

    // Карта цветов для параметра "color"
    $color_map = [];
    if ($is_color) {
        $color_map = [
            'white'  => '#f7f7f7',
            'black'  => '#000000',
            'gray'   => '#bababa',
            'red'    => '#ff0000',
            'blue'   => '#344fd0',
            'green'  => '#008000',
            'lime'   => '#32cd32',
            'yellow' => '#eeee12',
            'orange' => '#ff8c00',
            'pink'   => '#ff69b4',
            'purple' => '#800080',
            'brown'  => '#8b4513',
            'cyan'   => '#00ffff',
            'teal'   => '#008080',
            'indigo' => '#4b0082',
            'maroon' => '#800000',
            'navy'   => '#000080',
            'olive'  => '#808000',
        ];
    }

    if ($param_type === 'range') {
        $range_min = $values_raw['min'] ?? 0;
        $range_max = $values_raw['max'] ?? 100000;
        $filter_active = false;
        $min_selected = $range_min;
        $max_selected = $range_max;
        if ($input && is_string($input) && strpos($input, '-') !== false) {
            [$min_selected, $max_selected] = array_map('floatval', explode('-', $input));
            $filter_active = true;
        }
        $current_range_value = $filter_active ? ($min_selected . '-' . $max_selected) : '';
        $range_count = $filter_active
            ? marketprofilter_get_range_count($param_id, $min_selected, $max_selected, $current_cat)
            : 0;

        $t1->assign([
            'FILTER_PARAM_MIN'          => $range_min,
            'FILTER_PARAM_MAX'          => $range_max,
            'FILTER_PARAM_VALUE_MIN'    => $min_selected,
            'FILTER_PARAM_VALUE_MAX'    => $max_selected,
            'FILTER_PARAM_HIDDEN_VALUE' => $current_range_value,
            'FILTER_PARAM_OPTION_COUNT' => $range_count,
        ]);
        $t1->parse('FILTER_FORM.FILTER_PARAM.RANGE');
    } else {
        // Генерация HTML списка опций для select/checkbox/radio
        $counts = marketprofilter_get_faceted_counts($param_id, $current_cat);
        $list_html = '';

        foreach ($values_raw as $key) {
            $display_text = marketprofilter_get_value($param_id, $key, Cot::$usr['lang'] ?? 'ru');
            $is_selected = $input && (
                $param_type === 'checkbox'
                    ? in_array($key, (array)$input, true)
                    : ((string)$key === (string)$input)
            );
            $color = $is_color ? ($color_map[$key] ?? '') : '';
            $checked_attr = ($is_selected && in_array($param_type, ['checkbox','radio'])) ? 'checked' : '';
            $selected_attr = ($param_type === 'select' && $is_selected) ? 'selected' : '';
            $count = $counts[$key] ?? 0;
            $count_badge = $count > 0 ? '<span class="badge rounded-pill text-bg-warning me-1">' . (int)$count . '</span>' : '';

            switch (true) {
                case ($param_type === 'select'):
                    $list_html .= '<option value="' . htmlspecialchars($key) . '" ' . $selected_attr . '>'
                        . htmlspecialchars($display_text) . ' (' . (int)$count . ')</option>';
                    break;

                case ($is_color && $param_type === 'checkbox'):
                    $list_html .= '<div class="position-relative">'
                        . '<label class="filter-color-i">'
                        . '<input type="checkbox" name="filter_' . htmlspecialchars($param_name) . '[]" value="' . htmlspecialchars($key) . '" ' . $checked_attr . ' style="display:none;">'
                        . '<i class="filter-color-b" style="background-color: ' . htmlspecialchars($color) . ';" title="' . htmlspecialchars($display_text) . '" data-bs-toggle="tooltip"></i>';
                    if ($count > 0) {
                        $list_html .= '<div class="position-absolute top-0 end-0"><span class="badge rounded-pill text-bg-warning ms-1">' . (int)$count . '</span></div>';
                    }
                    $list_html .= '</label></div>';
                    break;

                case ($is_color && $param_type === 'radio'):
                    $list_html .= '<div class="position-relative">'
                        . '<label class="filter-color-i">'
                        . '<input type="radio" name="filter_' . htmlspecialchars($param_name) . '" value="' . htmlspecialchars($key) . '" ' . $checked_attr . ' style="display:none;">'
                        . '<i class="filter-color-b" style="background-color: ' . htmlspecialchars($color) . ';" title="' . htmlspecialchars($display_text) . '" data-bs-toggle="tooltip"></i>';
                    if ($count > 0) {
                        $list_html .= '<div class="position-absolute top-0 end-0"><span class="badge rounded-pill text-bg-warning ms-1">' . (int)$count . '</span></div>';
                    }
                    $list_html .= '</label></div>';
                    break;

                case ($param_type === 'checkbox'):
                    $list_html .= '<div class="form-check">'
                        . '<input type="checkbox" name="filter_' . htmlspecialchars($param_name) . '[]" value="' . htmlspecialchars($key) . '" class="form-check-input" ' . $checked_attr . '>'
                        . '<label class="form-check-label">' . $count_badge . htmlspecialchars($display_text) . '</label>'
                        . '</div>';
                    break;

                case ($param_type === 'radio'):
                    $list_html .= '<div class="form-check">'
                        . '<input type="radio" name="filter_' . htmlspecialchars($param_name) . '" value="' . htmlspecialchars($key) . '" class="form-check-input" ' . $checked_attr . '>'
                        . '<label class="form-check-label">' . htmlspecialchars($display_text) . ' (' . (int)$count . ')</label>'
                        . '</div>';
                    break;
            }
        }

        $t1->assign('FILTER_PARAM_LIST_HTML', $list_html);
        $t1->parse('FILTER_FORM.FILTER_PARAM.' . strtoupper($param_type));
    }

    $t1->parse('FILTER_FORM.FILTER_PARAM');
}

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